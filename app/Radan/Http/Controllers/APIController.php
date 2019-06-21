<?php

namespace App\Radan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Config\Repository as Config;
use App\Http\Controllers\Controller as BaseController;
use App\Radan\Fundation\Traits\RadanResponseCodeTrait;
use App\Radan\Fundation\Traits\RadanDataQueryFilterTrait;

class APIController extends BaseController 
{    
    use RadanResponseCodeTrait;
    use RadanDataQueryFilterTrait;
	
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
     * Instance of http request user
     * 
     * @var Request
     */
    protected $request;

    /**
     * Bind Model to Controller
     * 
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;    

    /**
     * Relations for eger loading
     * 
     * @var array
     */
    protected $relations = [       
    ];

    /**
     * Api resource class name
     * 
     * @var Illuminate\Http\Resources\Json\JsonResource
     */
    protected $jsonResource;

    /**
     * Api resource collection class name
     * 
     * @var Illuminate\Http\Resources\Json\ResourceCollection
     */
    protected $resourceCollection;

    /**
     * Instance of http request filter
     * 
     * @var array
     */
    protected $filters;

    protected $requestFilterName;

    protected $filterable = [        
    ];
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Config $config,Request $request)
    {
        $this->config = $config;
        $this->request = $request;
        $this->fetchFilters($request);         

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    
    protected function getModel($scopes = true)
    {
        if (class_exists($this->model))
        {
            $this->model = new $this->model();            
            if (method_exists($this,'where') and $scopes)
            {                              
                $whereModel = $this->where($this->model);
                $this->model = is_null($whereModel) ? $this->model: $whereModel; 
            }
            if ($this->hasFilter() and method_exists($this,'filter') and $scopes)
            {               
                if ($this->validateFilter()) {
                    $filterModel = $this->filter($this->model);
                    $this->model = is_null($filterModel) ? $this->model: $filterModel; 
                }
            }
            return $this->model;      
        }
        
        return null;        
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
        /*if (!$model->count()) {
          throw(new ModelNotFoundException);
        }*/
        // Determinde number of record to return
        $pgCount = $this->getPaginationCount();
        $records = ($pgCount) ? $model->paginate($pgCount) : $model->get();
        return $records;
    }

    /**
     * @authenticated 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all resources
        $model = $this->getModel();       
        $model = isset($this->relations) ? $model->with($this->relations):$model;        

        // Return json response
        if (isset($this->resourceCollection)) {            
            return $this->resourceCollection::collection($this->all($model));
        } else if (isset($this->jsonResource)) {
            return $this->jsonResource::collection($this->all($model));
        } else {
            return $this->all($model);
        }
    }

    /**
     * @authenticated  
     * Display the specified resource.
     *
     * @param  Integer    $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->getModel();
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
