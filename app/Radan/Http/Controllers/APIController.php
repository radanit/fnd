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
        
    /**
     * Fetch all records of model
     *
     * @return Model
     */
    protected function all($model)
    {
        // Determinde number of record to return
        $pgCount = $this->getPaginationCount();
        $records = ($pgCount) ? $model->paginate($pgCount) : $model->get();
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        // Get all resources
        $model = new $this->model();
        $model = isset($this->relations) ? $model->with($this->relations):$model;

        // Return api resource
        if (isset($this->jsonResource)) {
            return $this->jsonResource::collection($this->all($model));
        } else {
            return $this->all($model);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  Integer    $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = new $this->model();
        if (isset($this->relations)) {
            $record = $model->with($this->relations)->findOrFail($id);
        }
        else {
            $record = $model->findOrFail($id);
        }
                
        // Return JSON response
        return new $this->jsonResource($record);
    }    
}
