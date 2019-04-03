<?php

namespace App\Radan\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Radan\Http\Controllers\APIController;

class ConfigController extends APIController
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function index() {
        return 'wewe';
    }
}
