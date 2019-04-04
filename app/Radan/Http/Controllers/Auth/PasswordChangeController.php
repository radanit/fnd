<?php

namespace App\Radan\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Events\PasswordChanged;

class PasswordChangeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Change Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password change requests.
    |
    */   

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Display the password change view.    
     *
     * @param  \Illuminate\Http\Request  $request     
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangeForm(Request $request)
    {
        return view('auth.passwords.change');
    }

     /**
     * Change the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function change(Request $request)
    {
        $user = Auth::user();

        $request->validate($this->rules($user));

        $user->password = $request->password;

        if ($user->save()) {
            event(new PasswordChanged($user));
            return redirect($this->redirectTo)
                        ->with('status', __('app.deleteAlert'));
        } else {
            return response()->with('status', __('app.failedAlert'), 500);
        }       
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules($user)
    {
        return [           
            'password' => 'required|confirmed|'.$user->passwordPolicy,
        ];
    }    
}
