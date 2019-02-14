<?php

namespace App\Radan\Profile\Controllers;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Profile\Models\Profile;
use App\Radan\Profile\Models\PasswordPolicy;
use App\Radan\Resources\ProfileResource;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;

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
        // Read password policy table name form config
        $passwordPolicyTable = Config::get('radan.profile.tables.password_policies','password_policies');        
        
        // Validation rules
        Validator::make($request->only('name','description','structure','password_policy_id'), [
            'name' => 'required|string|max:255|unique:profiles',
            'description' => 'required|string|max:255',
            'structure' => 'required|string|json',
            'password_policy_id' => 'exists:'.$passwordPolicyTable.',id'
        ])->validate();
        
        // Create Profile
        try {            
            // get default password policy            
            $defaultPasswordPolicyId = PasswordPolicy::where('name','default')->first()->id;        
            $passwordPolicy = ($request->filled('password_policy_id')) ? 
                                $request->password_policy_id:$defaultPasswordPolicyId;
            
            $profile = Profile::create([
                'name' => $request->name,        
                'description' => $request->description,
                'structure' => $request->structure,
                'password_policy_id' => $passwordPolicy,
            ]);

            // Return
            return response()->json([
                'message' => __('app.insertAlert')],
                $this->httpCreated
            );

        } catch (Exception $e) {
            Log::error($e->getMessage());
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
        // Read password policy table name form config
        $passwordPolicyTable = Config::get('radan.profile.tables.password_policies','password_policies');        
        
        // Validation rules   
        Validator::make($request->only('description','structure','password_policy_id'), [
            'description' => 'required|string|max:255',
            'structure' => 'required|string|json',
            'password_policy_id' => 'exists:'.$passwordPolicyTable.',id',
        ])->validate();

        try {
            $profile = Profile::findOrFail($id);
            $profile->update($request->only(['description', 'structure','password_policy_id']));
            
            // Return
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {
            Log::error($e->getMessage());
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

        try {
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
            
        } catch(ResourceProtected $e) {            
            return $e->render();
        } catch(ResourceRestricted $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Error delete profile',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }                    
    }
}
