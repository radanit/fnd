<?php

namespace App\Bahar\Controllers;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;
use App\Bahar\Models\RadioType;
use App\Bahar\Resources\RadioTypeResource;

class RadioTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Return
        $count = Config::get('radan.pagination.count',15);    
        
        if ($count) {
            return RadioTypeResource::collection(RadioType::paginate($count));
        }
        else {
            return RadioTypeResource::collection(RadioType::all()); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation rules
        Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:radio_types',
            'description' => 'string|max:255',
            'roles' => 'exists:roles,id',

        ])->validate();

        try {
            // First create role in roles table     
            $radioType = RadioType::create([
                'name' => $request->name,
                'description' => $request->description,
                'role_id' => $request->roles
            ]);
                
            return response()->json([
                'message' => __('app.insertAlert')],
                $this->httpCreated
            );

        } catch (Exception $e) {                
            return response()->json([
                'message' => 'Error create radio type',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bahar\Models\RadioType  $radioType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return new RadioTypeResource(RadioType::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bahar\Models\RadioType  $radioType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // Validation permission   
        Validator::make($request->only('description','roles'), [
            'description' => 'string|max:255',
            'roles' => 'exists:roles,id'
        ])->validate();
        
        try {
            $radioType = RadioType::findOrFail($id);
            $radioType->update([
                'description' => $request->description,
                'role_id' => $request->roles
            ]);
                        
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {     
            dd($e)       ;
            return response()->json([
                'message' => 'Error update radio type',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bahar\Models\RadioType  $radioType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find role by id        
        $radioType = RadioType::findOrFail($id);                
            
        // Delete role, deattache user and permissions            
        $radioType->delete();
            
        // Return
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
