<?php

namespace App\Radan\Http\Controllers\API;

// Laravel classis
use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// Base Application classes
use App\Radan\Http\Controllers\APIController;

// Radan modules classes
use App\Radan\Resources\ProfileResource;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;

// This Module classes
use App\Radan\Profile\Models\Profile;

class ProfileController extends APIController
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // Return
        $count = Config::get(
            'radan.profile.models.pagination.count', 
            Config::get('radan.pagination.count',15)
        );
        
        if ($count) {
            return ProfileResource::collection(Profile::paginate($count));
        }
        else {
            return ProfileResource::collection(Profile::all()); 
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
        Validator::make($request->only('name','description','structure'), [
            'name' => 'required|string|max:255|unique:profiles',
            'description' => 'required|string|max:255',
            'structure' => 'required|string|json',           
        ])->validate();

        // Create Profile
        try {            
            $profile = Profile::create([
                'name' => $request->name,        
                'description' => $request->description,
                'structure' => json_decode($request->structure),              
            ]);

            // Return
            return response()->json([
                'message' => __('app.insertAlert')],
                $this->httpCreated
            );

        } catch (Exception $e) {            
            return response()->json([
                'message' => 'Error create profile',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProfileResource(Profile::findOrFail($id));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation rules   
        Validator::make($request->only('description','structure'), [
            'description' => 'required|string|max:255',
            'structure' => 'required|string|json',            
        ])->validate();

        try {
            $profile = Profile::findOrFail($id);

            $data = $request->only('description', 'structure');
            if (array_key_exists('structure',$data)) {
                $data['structure'] = json_decode($request->structure);
            }

            $profile->update($data);
            
            // Return
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error update profile',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)    
    {
        // destroy profile
        $profile = Profile::findOrFail($id);

        // Get prevernts from config files
        $prevents = Config::get('profile.prevents');

        // Check prevents rule
        if (!is_null($prevents)) {
            foreach ($prevents as $key => $value) {
                if ($profile->$key==$value) {
                    throw new ResourceProtected;
                }
            }
        }

        // Destory profile
        $profile->delete();
            
        // Return
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );                            
    }
}
