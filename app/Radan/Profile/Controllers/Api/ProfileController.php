<?php

namespace App\Radan\Profile\Controllers\Api;

// Laravel classis
use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// Base Application classes
use App\Http\Controllers\Controller;

// Radan modules classes
use App\Radan\Policy\PasswordPolicy\PasswordPolicy;
use App\Radan\Resources\ProfileResource;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;

// This Module classes
use App\Radan\Profile\Models\Profile;

class ProfileController extends Controller
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
        Validator::make($request->only('name','description','structure','password_policy_id','password'), [
            'name' => 'required|string|max:255|unique:profiles',
            'description' => 'required|string|max:255',
            'structure' => 'required|string|json',
            'password_policy_id' => 'exists:password_policies,id',
        ])->validate();

        // Create Profile
        try {            
            // get default password policy            
            $defaultPasswordPolicyId = PasswordPolicy::where('name','default')->first()->id;
            $passwordPolicy = ($request->filled('password_policy_id')) ? $request->password_policy_id:$defaultPasswordPolicyId;
            
            $profile = Profile::create([
                'name' => $request->name,        
                'description' => $request->description,
                'structure' => json_decode($request->structure),
                'password_policy_id' => $passwordPolicy,
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
        Validator::make($request->only('description','structure','password_policy_id'), [
            'description' => 'required|string|max:255',
            'structure' => 'required|string|json',
            'password_policy_id' => 'exists:password_policies,id',
        ])->validate();

        try {
            $profile = Profile::findOrFail($id);

            $data = $request->only(['description', 'structure','password_policy_id']);
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
        $prevents = Config::get('radan.profile.prevents.profiles');

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
