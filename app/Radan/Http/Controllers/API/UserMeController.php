<?php

namespace App\Radan\Http\Controllers\API;

// Laravel Libraries
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Radan Libraries
use Profile;
use App\Radan\Http\Controllers\APIController;
use App\Radan\Http\Resources\UserMeResource;

class UserMeController extends APIController
{    
    /**
     * Retrieve profile of the current user
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request)
    {        
        return new UserMeResource($this->user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        // Populate Profile Data and validate it
        $profileData = Profile::set($this->user->type_id)->getData($request);        
        Profile::validate($profileData);
                
        // Update profile
        Profile::update($user,$profileData);		
                                       
        return response()->json([
            'message' => __('app.updateAlert')],
            $this->httpOk
        );
    }

    
}