<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{

    public function handle(Request $request, Closure $next): mixed
    {
        $bearer = null;
        if ($request->header("Authorization") != null) {
            $bearer = substr($request->header("Authorization")->toString(), 7);
        }

        if ($bearer) {
            $user = User::fromToken($bearer);

            if ($user === null) {
                return response([
                    "message" => "access denied",
                ], 403);
            }

            Auth::onceUsingId($user->id);
        } else if ($request->has("api_key")) {
            $user = User::fromToken($request->post("api_key"));

            if ($user === null) {
                $user = ApiToken::userFromToken($request->post("api_key"));
            }

            if ($user === null) {
                return response([
                    "message" => "access denied",
                ], 403);
            }

            Auth::onceUsingId($user->id);
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
                    "api_key" => $request->post("api_key"),
                ], 403);
            }
        }

        return $next($request);
    }
}
