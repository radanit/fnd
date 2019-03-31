<?php

namespace App\Radan\Http\Controllers\API;

// Laravel Libraries
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Radan Libraries
use App\Radan\Http\Controllers\APIController;

use Profile;
use App\Radan\Auth\Models\User;


class UserAvatarController extends APIController
{        

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return  $this->user->avatar;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Populate Profile Data and validate it        
        $profileData = Profile::set($this->user->type_id)->getData($request,'avatar');        
        Profile::validate($profileData,'avatar');

        // Save uploaded file        
        $profileData = Profile::update($this->user,$profileData);

        // Return        
        return response()->json([
            'message' => __('app.updateAlert'),
            'url' =>  $profileData['avatar']],
            $this->httpOk
        );
    }
}
