<?php

namespace App\Radan\Controllers;

use Illuminate\Contracts\Config\Repository as Config;
use App\Http\Controllers\Controller as BaseController;
use App\Radan\Traits\RadanResponseCodeTrait;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Config $config)
    {        
        $this->config = $config;       
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
