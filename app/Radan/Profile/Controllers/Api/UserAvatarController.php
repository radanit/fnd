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
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;

// This Module classes
use App\Radan\Profile\Models\Profile;
use App\Radan\Profile\Models\User;

class UserAvatarController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $user  = \Auth::user();
        if ($user->id) return $user->avatar;
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
        Validator::make($request->only('avatar'), [
            'avatar' => 'bail|required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ])->validate();

        $userId  = \Auth::user()->id;
        $profile = User::findOrfail($userId)->profile;
        
        dd($profile->family);
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
    public function destroy()
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
