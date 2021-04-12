<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function apiLogin(\Illuminate\Http\Request $request): mixed
    {
        if ($request->has("api_key")) {
            $user = ApiToken::userFromToken($request->post("api_key"));

            if ($user === null) {
                return response([
                    "message" => "access denied",
                ], 403);
            }

            Auth::guard()->login($user, true);
            return redirect("profile");
        } else {
            return $this->login($request);
        }
    }
}
