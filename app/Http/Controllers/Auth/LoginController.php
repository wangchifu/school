<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    //改以username登入，非email
    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        if(env('LOGIN_LOCAL_OR_LDAP')=="local"){
            $this->validateLogin($request);

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }elseif(env('LOGIN_LOCAL_OR_LDAP')=="ldap"){
            $adServer = env('OPENLDAP_SERVER');

            $ldap = ldap_connect($adServer);
            $username = $request->input('username');
            $password = $request->input('password');

            $ldaprdn = env('OPENLDAP_ACCOUNT_PREFIX') . "=" . $username.",".env('OPENLDAP_BASE_DN');

            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

            $bind = @ldap_bind($ldap, $ldaprdn, $password);


            if($bind){
                @ldap_close($ldap);

                $user = User::where('username',$request->input('username'))
                    ->first();

                if(empty($user)){
                    $error = \Illuminate\Validation\ValidationException::withMessages([
                        'field_name_1' => ['本機無此帳號'],
                    ]);
                    throw $error;
                }else{

                    //更新密碼
                    $att['password'] = bcrypt($request->input('password'));
                    $user->update($att);

                    session(['username'=>$request->input('username')]);
                    session(['password'=>$request->input('password')]);

                    if(Auth::attempt(['username' => session('username'), 'password' => session('password')])){
                        return redirect()->route('index');
                    }

                }
            }else{
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'field_name_1' => ['帳號密碼錯誤'],
                ]);
                throw $error;
            }
        }

    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
