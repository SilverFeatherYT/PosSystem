<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
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
    // protected $redirectTo = RouteServiceProvider::HOME;


    protected function redirectTo()
    {
        if (Auth::check() && Auth::user()->D_role == '2') {
            return route('viewMain');
        } elseif (Auth::check() && Auth::user()->D_role == '1') {
            return route('viewPos');
        } else {
            return route('viewRedeem');
        }
    }

    public function username()
    {
        // Allow users to log in using either 'email' or 'name' field
        $loginValue = request()->input('name');

        $fieldType = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        request()->merge([$fieldType => $loginValue]);

        return $fieldType;
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated() //check if other devices login with logout the first devices
    {
        Auth::logoutOtherDevices(request('password'));
    }
}
