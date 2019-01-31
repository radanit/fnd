<?php

namespace App\Radan\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\User;
use App\Radan\Auth\Request\UserRequest;
use App\Radan\Resources\UserResource;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return 
        return UserResource::collection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'active' => 'boolean',
            'profile_id' => 'required|exists:profiles:id',
            'profile_data' => 'required|json'
        ]);

        // First create user in users table     
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'active' => $request->active,
        ]);

        // Then create profile info base on profile type 
        $user->userProfile()->create([           
            'profile_id' => $request->profile_id,
            'data' => $request->profile_date,
        ]);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {        
        // Validation
        $request->validate([           
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'string|min:6|confirmed',
            'active' => 'boolean',
            'profile_id' => 'exists:profiles:id',
            'profile_data' => 'json'
        ]);

        // Update user profile data
        $user = User::findOrFail($id);
        $userProfile = $user->userProfile()->first();
        $userProfile->profile_id = ($request->has('profile_id')) ? $request->profile_id: $userProfile->profile_id;
        $userProfile->data = ($request->has('profile_data')) ? $request->profile_data: $userProfile->data;

        $user->update($request->only(['email', 'password', 'active']));

        


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
        // Find user by id
        $user = User::findOrFail($id);

        // Find user_profile record by user_id relation
        $user->userProfile()->delete();
        $user->delete();        
        
        return response()->json(null, 204);
    }
}
