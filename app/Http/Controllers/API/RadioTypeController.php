<?php

namespace App\Http\Controllers\API;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


use App\Radan\Http\Controllers\APIController;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;
use App\Models\RadioType;
use App\Http\Resources\RadioTypeResource;

class RadioTypeController extends APIController
{
    
    /**
     * Bind Model to Controller
     * 
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model = RadioType::class;

    /**
     * Relations for eger loading
     * 
     * @var array
     */
    protected $relations = [
        'role',
    ];

    /**
     * Api resource class name
     * 
     * @var Illuminate\Http\Resources\Json\JsonResource
     */
    protected $jsonResource = RadioTypeResource::class;
    

    /**
     * Return number of records return per page
     *
     * @return integer
     */
	protected function getPaginationCount()
	{
        // means return all data rows
        return 0;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Request
        Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:radio_types',
            'description' => 'string|max:255',
            'roles' => 'nullable|exists:roles,id',
            'radio_cat_id' => 'required|max:1'

        ])->validate();

        // Create Resource
        $radioType = RadioType::create([
            'name' => $request->name,
            'description' => $request->description,
            'role_id' => $request->roles,
            'radio_cat_id' =>$request->radio_cat_id
        ]);
            
        // Return JSON response    
        return response()->json([
            'message' => __('app.insertAlert')],
            $this->httpCreated
        );    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // Validation Request 
        //dd($request->all());
        Validator::make($request->only('description','roles','radio_cat_id'), [
            'description' => 'string|max:255',
            'roles' => 'exists:roles,id',
            'radio_cat_id' => 'required|max:1'
        ])->validate();
        
        // Find Resource and update it
        // ModelNotFoundException throw if Resource not found
        $radioType = RadioType::findOrFail($id);
        $radioType->update([
            'description' => $request->description,
            'role_id' => $request->roles,
            'radio_cat_id' => $request->radio_cat_id
        ]);
            
        // Return JSON response            
        return response()->json([
            'message' => __('app.updateAlert')],
            $this->httpOk
        );        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find Resource
        // ModelNotFoundException throw if Resource not found
        $radioType = RadioType::findOrFail($id);                
            
        // Delete Resource           
        $radioType->delete();
            
        // Return JSON response
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }

    /**
     * Apply query filters validation rules
     * 
     * 
     * @return array of laravel validation rules
     */
    protected function filterRules() 
    {
        return [];
    }
    
    /**
     * Apply query filters 
     * 
     * @param Eloquent $query
     * @return Eloquent
     */
    protected function filter($query)
    {                
        return $query->where('name',$this->getFilter('name'));       
    }
}
