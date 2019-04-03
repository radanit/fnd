<?php

namespace App\Radan\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Config\Repository as Config;
use App\Http\Controllers\Controller as BaseController;
use App\Radan\Fundation\Traits\RadanResponseCodeTrait;

class APIController extends BaseController
{    
    use RadanResponseCodeTrait;
	
	/**
     * Instance of config repository
     * 
     * @var Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Instance of authenticated user
     * 
     * @var User
     */
    protected $user;
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Config $config)
    {        
        $this->config = $config;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });       
    } 
	
	/**
     * Return number of records return per page
     *
     * @return integer
     */
	protected function getPaginationCount()
	{
		return $this->config->get('radan.pagination.count',15);                    
    }
}
