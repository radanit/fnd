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
     * Set authenticated user
     * 
     */
    protected function user()
    {
        return Auth::user();
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
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
        $profileData = Profile::set($this->user()->type_id)
            ->update($this->user(),$request->only('avatar'));

        // Return        
        return response()->json([
            'message' => __('app.updateAlert'),
            'url' =>  $profileData['avatar']],
            $this->httpOk
        );
    }
}
