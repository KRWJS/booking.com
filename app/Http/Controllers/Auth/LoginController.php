<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/comasy';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');

        return array_add($credentials, 'activated', '1');
    }

    public function authenticated(Request $request, User $user)
    {
/*        // only activated users can login
        if ($user->activated) {
            return redirect()->intended($this->redirectTo);
        } else {
            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();

            return redirect('comasy/login')
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['activated' => 'You must be activated to be able to login.']);
        }*/

        $user->last_login = new \DateTime();
        $user->save();

        return redirect()->intended($this->redirectTo);
    }
}
