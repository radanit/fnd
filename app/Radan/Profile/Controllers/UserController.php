<?php

namespace App\Radan\Profile\Controllers;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\User;
use App\Radan\Auth\Models\Role;
use App\Radan\Profile\Models\ProfileUser;
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
        // Get number of pagination count
        $count = Config::get(
            'radan.profile.models.pagination.count',
            Config::get('radan.pagination.count',15)
        );
        
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
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Begin Database transaction			
        DB::beginTransaction();
        try {
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
            $user->attachRoles($roles);
            
            // Return
            DB::commit();
            return response()->json([
                'message' => __('app.insertAlert')],
                $this->httpCreated
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Error create user',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }                
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
            'profile_id' => 'exists:'.$profileTable.',id',
            'profile_data' => 'json',
			'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);
		
		// Begin Database transaction			
        DB::beginTransaction();
        try{
            // Find user
            $user = User::findOrFail($id);
			$updates = $request->only('email','active','password');
            if ($request->has('password')) {
                $updates['password'] = bcrypt($request->password);				;
            }            
			$user->update($updates);
						
            // Set user profile data
			if ($request->filled('profile_id')) {
				$profileUser = $user->profileUser()->first();
				$profileUser->profile_id = $request->profile_id;
				$profileUser->data = ($request->filled('profile_data')) ? $request->profile_data: $profileUser->data;
				$user->profileUser()->save($profileUser);
			}
                           
            // Set user roles and update
            if ($request->filled('roles')) {
				$user->syncRoles($request->roles);
            }

            // Return 
            DB::commit();
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Error update user',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }
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

        try {
            // Find user_profile record by user_id relation
            $user->profileUser()->delete();

            // deattach all roles and permmisions
            $user->syncRoles([]);
            $user->syncPermissions([]);

            // delete user
            $user->delete();        
            
            /// Return
            return response()->json([
                'message' => __('app.deleteAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {        
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Error delete user',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }                    
    }
}