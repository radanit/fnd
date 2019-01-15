<?php

namespace App\Radan\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Radan\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Request\LoginRequest;
use Carbon\Carbon;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Login user and create token
     *
     * @param  [string] username     
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function authenticate(LoginRequest $loginRequest)
    {   
        // Create http client for post request7
        $request = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => env('PGC_CLIENT_ID'),
            'client_secret' => env('PGC_CLIENT_SECRET'),
            'username' => $loginRequest->username,
            'password' => $loginRequest->password,
        ]);

        // Send post request to oauth server and get token result
        $response = json_decode(app()->handle($request)->getContent(),true);

        if (isset($response['error']))
        {        
            return response()->json([
                'message' => 'The user credentials were incorrect'
            ],401);
        }
        else
        {            
            // Ckech if remember_me checked, Set token expire
            if ($loginRequest->remember_me) {            
                $user = User::Where('username',$loginRequest->username)->first();
                $token = $user->tokens()->first();
                $token->expires_at = Carbon::now()->addWeeks(5);
                $token->save();         
            }                
            return $response;
        }
    }    

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function revoke(Request $request)
    {        
        // Logout token base authenticate
        $request->user()->token()->revoke();                
        
        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }
}
