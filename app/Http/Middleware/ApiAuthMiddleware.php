<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->has("api_token")) {
            $user = ApiToken::userFromToken($request->post("api_key"));

            if ($user === null) {
                return response([
                    "message" => "access denied",
                ], 403);
            }
        } else {
            Auth::once([
                "email" => $request->post("email"),
                "password" => $request->post("password"),
            ]);

            if (Auth::guest()) {
                return response([
                    "message" => "wrong credentials",
                    "email" => $request->post("email"),
                    "password" => $request->post("password"),
                ], 403);
            }
        }

        Auth::onceUsingId($user->id);

        return $next($request);
    }
}
