<?php

namespace App\Radan\Profile\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Radan\Profile\Models\Profile;
use App\Radan\Resources\ProfileResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Radan\Profile\Request\ProfileRequest;

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
        return ProfileResource::collection(Profile::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileRequest $request)
    {
        //        
        $profile = Profile::create([
            'name' => $request->name,        
            'description' => $request->description,
            'structure' => $request->structure,
        ]);

        return new ProfileResource($profile);
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
    public function update(ProfileRequest $request, $id)
    {        
      $profile = Profile::find($id);
      $profile->update($request->only(['name', 'description', 'structure']));

      return new ProfileResource($profile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::find($id);
        $profile->delete();
        return response()->json(null, 204);
    }
}
