<?php

namespace App\Radan\Profile\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Radan\Profile\Models\UserProfile;
use App\Radan\Profile\Resources\UserProfileResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Radan\Profile\Request\UserProfileRequest;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return 
        return UserProfileResource::collection(UserProfile::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserProfileRequest $request)
    {
        //        
        $userProfile = UserProfile::create([
            'name' => $request->name,        
            'description' => $request->description,
            'structure' => $request->structure,
        ]);

        return new UserProfileResource($userProfile);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserProfileResource(UserProfile::findOrFail($id));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserProfileRequest $request, $id)
    {        
      $userProfile = UserProfile::find($id);
      $userProfile->update($request->only(['name', 'description', 'structure']));

      return new UserProfileResource($userProfile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userProfile = UserProfile::find($id);
        $userProfile->delete();
        return response()->json(null, 204);
    }
}
