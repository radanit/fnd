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
use App\Radan\Auth\Models\User;

class UserAvatarController extends Controller
{        
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    
    protected function user()
    {
        return Auth::user();
    }

    public function index()
    {
        return Storage::url($this->user()->avatar);
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
        //$avatarPath = $request->file('avatar')->store('avatars','public');
        $avatarPath = Storage::disk('profile_avatar')->putFile('',$request->file('avatar'));
        
        dd(Storage::disk('profile_avatar'));
        /*$avatarPath = $request->file('avatar')->store(
            '', 'profile_avatar'
        );*/

        // Get profile user instance and save old user avatar temporary
        $profile = $this->user()->profile()->first();
        $oldUserAvatar = key_exists('avatar',$profile->data) ? $profile->data['avatar']:'';        
        
        // Save changes
        $profileData = $profile->data;
        $profileData['avatar'] = $avatarPath;
        $profile->data = $profileData;
        $this->user()->profile()->save($profile);

        // Delete old user avatar
        Storage::delete($oldUserAvatar);

        // Return
        return response()->json([
            'message' => __('app.updateAlert'),
            'url' =>  Storage::url($avatarPath)],
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
        // Get profile user instance and save old user avatar temporary
        $profile = $this->user()->profile()->first();
        $oldUserAvatar = $profile->data['avatar'];
        
        // Save changes
        $profileData = $profile->data;            
        $profileData['avatar'] = '';
        $profile->data = $profileData;
        $this->user()->profile()->save($profile);

        // Delete old user avatar
        Storage::delete($oldUserAvatar);

        // Return
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
