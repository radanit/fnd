<?php

namespace App\Radan\Profile\Controllers\Api;

// Laravel classis
use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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

    public function __construct()
    {      
    }

    public function index(User $user)
    {        
        dd($user->id);
        return asset($this->user->avatar);
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

        // Save uploaded file
        $path = $request->file('avatar')->store('avatars');

        // Get user instance and profile user
        $user = User::findOrFail(\Auth::id());
        $profile = $user->profile()->first();
        
        // Save changes
        $profileData = $profile->data;
        $preUserAvatar = $profileData['avatar'];
        
        $profileData['avatar'] = $path;
        $profile->data = $profileData;
        $user->profile()->save($profile);

        Storage::delete($preUserAvatar);

        // Return
        return response()->json([
            'message' => __('app.updateAlert')],
            $this->httpOk
        );        
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
