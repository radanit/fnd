<?php

namespace App\Radan\Profile\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\User;
use App\Radan\Auth\Models\Role;
use App\Radan\Profile\Models\ProfileUser;
use App\Radan\Auth\Request\UserRequest;
use App\Radan\Resources\UserResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get number of pagination count
        $count = Config::get('radan.profile.models.pagination.count',
                             Config::get('radan.pagination.count',15));
        
        // Return        
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

        // Create profile info base on profile type 
        $user->profileUser()->create([           
                'profile_id' => $request->profile_id,
                'data' => $request->profile_date,
        ]);        

        // Find role and assigned to user
        $roles = is_array($request->roles) ? $request->roles: explode(',',$request->roles);
        //$roles = Role::findMany($roles);
        $user->attachRoles($roles);
        /*foreach ($roles as $role) {
            $user->attachRole($role);
        }   */ 

        // Return
        return response()->json(['message' => __('app.insertAlert') ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Return
        return new UserResource(User::findOrFail($id));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        // Read Profile table name form config
        $profileTable = Config::get('radan.profile.tables.profiles','profiles');

        // Validation        
        $request->validate([            
            'email' => 'string|email|max:255|unique:users',                        
            'password' => 'string|min:6|confirmed',
            'active' => 'boolean',
            'profile_id' => 'required|exists:'.$profileTable.',id',
            'profile_data' => 'json',
            'roles.*' => 'exists:roles,id',
        ]);

        DB::beginTransaction();
        try{
            // Find user
            $user = User::findOrFail($id);
            if ($request->has('password')) {
                Input::replace(['password' => bcrypt($request->password)]);
                //$request->password = bcrypt($request->password);
            }
            $user->update($request->only('email','active','password'));
        
            // Set user profile data            
            $profileUser = $user->profileUser()->first();
            $profileUser->profile_id = $request->profile_id;
            $profileUser->data = ($request->has('profile_data')) ? $request->profile_data: $profileUser->data;
            $user->profileUser()->save($profileUser);
                           
            // Set user roles and update        
            if ($request->has('roles')) {
                $roles = is_array($request->roles) ? $request->roles: explode(',',$request->roles);
                $rolesCnt = Role::findMany($roles)->count();
                if ($rolesCnt==count($roles) and $rolesCnt) {
                    $user->syncRoles($roles);
                }
            }
        } catch (\Exception $e) {
            // Return 
            DB::rollBack();
            return response()->json(['message' => 'Error update user' , 'errors' => __('app.failedAlert') ], 500);
        }

        // Return 
        DB::commit();
        return response()->json(['message' => __('app.updateAlert') ], 200);
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

        // deattach all roles and permmisions
        $user->syncRoles([]);
        $user->syncPermissions([]);

        // delete user
        $user->delete();        
        
        // return 
        return response()->json(['message' => __('app.deleteAlert') ], 200);
    }
}