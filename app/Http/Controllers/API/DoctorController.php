<?php

namespace App\Http\Controllers\API;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


use App\Radan\Http\Controllers\APIController;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;
use App\Models\Doctor;
use App\Resources\DoctorResource;

class DoctorController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        // Return JSON response
        $count = Config::get('radan.pagination.count',15);    
        
        if ($count) {            
            $doctors = Doctor::with('speciality')->paginate($count);
        }
        else {
            $doctors = Doctor::with('speciality')->get();
        }
        return DoctorResource::collection($doctors);
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
            'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',            
            'specialities' => 'required|exists:specialities,id',
        ])->validate();

        // Create Resource
        $doctor = Doctor::create([
            'first_name' => $request->first_name,
			'last_name' => $request->last_name,                
            'speciality_id' => $request->specialities
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
     * @param  Integer    $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Return JSON response
        return new DoctorResource(Doctor::with('speciality')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // Validation Request   
        Validator::make($request->only('first_name','last_name','specialities'), [
            'first_name' => 'string|max:255',
			'last_name' => 'string|max:255',
            'specialities' => 'exists:specialities,id'
        ])->validate();
        
        // Find Resource and update, 
        // ModelNotFoundException throw if Resource not found
        $Doctor = Doctor::findOrFail($id);
        $Doctor->update([
            'first_name' => $request->first_name,
			'last_name' => $request->last_name,
            'speciality_id' => $request->specialities
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
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find Resource by id
        // ModelNotFoundException throw if Resource not found
        $doctor = Doctor::findOrFail($id);                
            
        // Delete Resource
        $doctor->delete();
            
        // Return JSON response
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
