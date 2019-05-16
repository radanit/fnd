<?php

namespace App\Radan\Http\Controllers\API;

// Laravel Libraries
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Radan Libraries
use App\Radan\Http\Controllers\APIController;

use Profile;
use App\Radan\Auth\Models\User;
use App\Radan\Auth\Models\Role;
use App\Radan\Fundation\Exceptions\ResourceProtected;
use App\Radan\Http\Resources\UserResource;
use App\Radan\Auth\Requests\StoreUserRequest;
use App\Radan\Auth\Requests\UpdateUserRequest;

class UserController extends APIController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all resources
        $userModel = User::with(['profile','roles']);

        // Determinde number of record to return
        $pgCount = $this->getPaginationCount();
        $users = ($pgCount) ? $userModel->paginate($pgCount) : $userModel->get();
        
        return UserResource::collection($users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTrashed()
    {
        // Get all resources
        $userModel = User::withTrashed('profile')->onlyTrashed();

        // Determinde number of record to return
        $pgCount = $this->getPaginationCount();
        $users = ($pgCount) ? $userModel->paginate($pgCount) : $userModel->get();
        
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
       
        // Populate Profile Data and validate it        
        $profileData = Profile::set($request->profile_id)->getData($request);
        Profile::validate($profileData);        

        // Begin Database transaction			
        DB::beginTransaction();
        try {
            // First create user in users table     
            $user = User::create($request->all());

            // Save profile data
            Profile::create($user,$profileData);
            
            // Find role and assigned to user
            if ($request->filled('roles')) {               
                $user->attachRoles($request->roles);
            }
            
            // Return
            DB::commit();
            return response()->json([
                'message' => __('app.insertAlert')],
                $this->httpCreated
            );

        } catch (Exception $e) {
            DB::rollBack();
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
    public function update(UpdateUserRequest $request, $id)
    {
        
        // Find user or fail
        $user = User::findOrFail($id);

        // Check profile type or data change
        // Populate Profile Data and validate it
        $profileId = isset($request->profile_id) ? $request->profile_id: $user->type_id;
        $profileData = Profile::set($profileId)->getData($request);        
        Profile::validate($profileData);
                
		// Begin Database transaction			
        DB::beginTransaction();
        try {            
            // Updata user
            $user->update($request->all());
						
            // Update profile
            Profile::update($user,$profileData);		
                           
            // Update roles
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

        // Get prevernts from config files
        $prevents = config('radan.auth.prevents.users');       

        // Check prevents rule
        if (!is_null($prevents)) {
            foreach ($prevents as $key => $value) {
                if ($user->$key==$value) {
                    throw new ResourceProtected;
                }
            }
        }

        try {
            // Find user_profile record by user_id relation
            Profile::destroy($user);

            // Deattach all roles and permmisions
            $user->syncRoles([]);
            $user->syncPermissions([]);

            // Delete user
            $user->delete();        
            
            // Return
            return response()->json([
                'message' => __('app.deleteAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error delete user',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }        
    }
}