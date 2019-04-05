<?php

namespace App\Http\Controllers\API;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


use App\Radan\Http\Controllers\APIController;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;
use App\Models\Speciality;
use App\Resources\SpecialityResource;

class SpecialityController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Determinde number of record to return
        $pgCount = $this->getPaginationCount();
        $specialities = ($pgCount) ? Speciality::paginate($pgCount) : Speciality::all();
        
        return SpecialityResource::collection($specialities);		
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
            'name' => 'required|string|max:255|unique:specialities',
            'description' => 'string|max:255',            
        ])->validate();
        
        // Create Resource     
        $speciality = Speciality::create([
            'name' => $request->name,
            'description' => $request->description,               
        ]);
                
        // Return JSON response
        return response()->json([
            'message' => __('app.insertAlert')],
            $this->httpCreated
        );        
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $id ,Speciality id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Return JSON response
        return new SpecialityResource(Speciality::findOrFail($id));
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
        // Validation Request  
        Validator::make($request->only('description'), [
            'description' => 'string|max:255',            
        ])->validate();
                
        // Find Resource and update, 
        // ModelNotFoundException throw if Resource not found
        $speciality = Speciality::findOrFail($id);
        $speciality->update([
            'description' => $request->description,                
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
        // Find Resource by id
        // ModelNotFoundException throw if Resource not found        
        $speciality = Speciality::findOrFail($id);                
            
        // Delete Resource            
        $speciality->delete();
            
        // Return JSON response
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
