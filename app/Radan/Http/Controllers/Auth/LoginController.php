<?php

namespace App\Radan\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Radan\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Request\LoginRequest;
use App\Radan\Fundation\Contracts\Repository;
use App\Radan\Auth\Events\UserLoggedIn;


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
   
    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Username Customization
     * By default, Laravel uses the email field for authentication. 
     * If you would like to customize this, 
     *  you may define a username method on your LoginController.
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        // return $request->only($this->username(), 'password');
        $credentials = $request->only($this->username(), 'password');        
        $credentials['active'] =  1;        
        return $credentials;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Call user login event
		event(new UserLoggedIn($user));		
    }
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
    protected $redirectAfterLogout;

    /**
     * config dependency.
     *
     * @var string
     */
    protected $config ;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Repository $config)
    {        
        $this->middleware('guest')->except('logout');
        
        // Get config object form application service container
        $this->config = $config;
        
        // Get redirectTo,check if null set default
        $this->redirectTo = $this->config->get('radan.auth.redirectTo');
        if (!$this->redirectTo) {           
            $this->config->set('radan.auth.redirectTo','/home');                    
        }

        // Get redirectAfterLogout,check if null set default
        $this->redirectAfterLogout = $this->config->get('radan.auth.redirectAfterLogout');
        if (!$this->redirectAfterLogout) {
            $this->config->set('radan.auth.redirectAfterLogout','login');          
        }        
    
    }

    /**
     * Logout user (Revoke the session)
     *  Customize logut redirect
     * 
     * @return [string] message
     */
    public function logout(Request $request)
    {        
        $this->performLogout($request);
        return redirect()->route($this->redirectAfterLogout);
    }    
}
