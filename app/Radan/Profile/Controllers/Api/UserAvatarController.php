<?php

namespace App\Radan\Profile\Controllers\Api;

// Laravel classis
use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
//use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// Base Application classes
use App\Http\Controllers\Controller;

// Radan modules classes
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;

// This Module classes
use App\Radan\Auth\Models\User;
use Profile;

class UserAvatarController extends Controller
{        
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    protected $disk;

    protected function user()
    {
        return Auth::user();
    }

    public function __construct(FileSystem $disk)
    {
        $this->disk = $disk;
    }

    public function index()
    {
        return  $this->user()->avatar;
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
        $profileData = Profile::make($this->user()->type_id)
                    ->update($this->user(),$request->only('avatar'));

        // Return        
        return response()->json([
            'message' => __('app.updateAlert'),
            'url' =>  $profileData['avatar']],
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
        $this->disk->delete(basename($oldUserAvatar));

        // Return
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
