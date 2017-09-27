<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\User;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function credentials(Request $request)
    {
        return [
        'email' => $request->email,
        'password' => $request->password,
        'verified' => 1,
        ];
    }

    // overwritten function from AuthenticatesUsers with errors added for not verified registered users
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

         // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password) && $user->verified != 1) {
            $errors = ['message' => 'You have to verify your account. Please check your email and click on verification link'];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        
        
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
        
    }

}
