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
use App\Bahar\Models\Doctor;
use App\Bahar\Resources\DoctorResource;

class DoctorController extends Controller
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
            return DoctorResource::collection(Doctor::paginate($count));
        }
        else {
            return DoctorResource::collection(Doctor::all()); 
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
            'name' => 'required|string|max:255',
			'family' => 'required|string|max:255',            
            'specialities' => 'exists:specialities,id',

        ])->validate();

        try {
            // First create role in roles table     
            $doctor = Doctor::create([
                'name' => $request->name,
				'family' => $request->family,                
                'speciality_id' => $request->specialities
            ]);
                
            return response()->json([
                'message' => __('app.insertAlert')],
                $this->httpCreated
            );

        } catch (Exception $e) {                
            return response()->json([
                'message' => 'Error create doctors',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bahar\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return new DoctorResource(Doctor::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bahar\Models\Doctor  $Doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // Validation permission   
        Validator::make($request->only('name','family','specialities'), [
            'name' => 'string|max:255',
			'family' => 'string|max:255',
            'specialities' => 'exists:specialities,id'
        ])->validate();
        
        try {
            $Doctor = Doctor::findOrFail($id);
            $Doctor->update([
                'name' => $request->name,
				'family' => $request->family,
                'speciality_id' => $request->specialities
            ]);
                        
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {             
            return response()->json([
                'message' => 'Error update doctors information',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bahar\Models\Doctor  $Doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find role by id        
        $doctor = Doctor::findOrFail($id);                
            
        // Delete role, deattache user and permissions            
        $doctor->delete();
            
        // Return
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
