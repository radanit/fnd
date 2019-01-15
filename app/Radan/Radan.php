<?php

namespace App\Radan;

use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar as Router;

class Radan
{
    
    //public static $cookie = 'laravel_token';

    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected  $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct()
    {
        //$this->router = $router;
    }            
}
