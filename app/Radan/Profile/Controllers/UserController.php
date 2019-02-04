<?php

namespace App\Radan\Profile\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\User;
use App\Radan\Auth\Models\Role;
use App\Radan\Profile\Models\ProfileUser;
use App\Radan\Auth\Request\UserRequest;
use App\Radan\Resources\UserResource;
use Illuminate\Support\Facades\Config;


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
        $count = Config::get('radan.profile.models.pagination.count',
                             Config::get('radan.pagination.count',15));
        if ($count) {
            return UserResource::collection(User::paginate($count));
        }
        else {
            return UserResource::collection(User::all());
        }        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        // Read Profile table name form config
        $profileTable = Config::get('radan.profile.tables.profiles','profiles');
                
        // Validation
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',                        
            'password' => 'required|string|min:6|confirmed',
            'active' => 'boolean',
            'profile_id' => 'required|exists:'.$profileTable.',id',
            'profile_data' => 'json',
            'roles' => '',            
        ]);

        // First create user in users table     
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'active' => $request->active,
        ]);

        // create profile info base on profile type 
        $user->profileUser()->create([           
                'profile_id' => $request->profile_id,
                'data' => $request->profile_date,
        ]);        

        // find role and assigned to user
        $roles = is_array($request->roles) ? $request->roles: explode(',',$request->roles);
        $roles = Role::findMany($roles);
        foreach ($roles as $role) {
            $user->attachRole($role);
        }    

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
        $user->profileUser()->delete();
        $user->delete();        
        
        return response()->json(['message' => __('app.deleteAlert') ], 200);
    }
}