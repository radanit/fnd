<?php

namespace App\Radan\Profile\Controllers\Api;

// Laravel classis
use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\DB;

// Base Application classes
use App\Http\Controllers\Controller;

// Radan modules classes
use App\Radan\Auth\Models\Role;
use App\Radan\Resources\UserResource;
use App\Radan\Resources\AuthUserResource;
use PasswordPolicy;
use Profile;

// This Module classes
use App\Radan\Auth\Models\User as AuthUser;
use App\Radan\Profile\Requests\StoreUserRequest;
use App\Radan\Profile\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Instance of config repository
     * 
     * @var Illuminate\Contracts\Config\Repository
     */
    protected $config;
    protected $paginationCount;    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request,Config $config)
    {                        
        $this->config = $config;
        $this->paginationCount = $this->config->get(
            'profile.models.pagination.count',
            $this->config->get('radan.pagination.count',15)
        );        
    }    
    
    /**
     * Display Authenticated user information
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function user(Request $request)
    {
        $user = Auth::user();
        return new AuthUserResource($user);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return        
        if ($this->paginationCount) {
            // eager loading pagination
            return UserResource::collection(AuthUser::with(['profile','roles'])->paginate($this->paginationCount));
        }
        else {
            // eager loading all
            return UserResource::collection(AuthUser::with(['profile','roles'])->get());
        }        
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
        $profileData = Profile::set($request->profile_id)
            ->setDataBag('profile_data')
            ->getData($request);
        Profile::validate($profileData);                

        // Begin Database transaction			
        DB::beginTransaction();
        try {
            // First create user in users table     
            $user = AuthUser::create($request->all());

            // Save profile data
            Profile::create($user,$profileData);
            
            // Find role and assigned to user
            if ($request->filled('rules')) {               
                $user->attachRoles($roles);
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
        return new UserResource(AuthUser::findOrFail($id));        
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
        $user = AuthUser::findOrFail($id);

        // Check profile type or data change
        // Populate Profile Data and validate it
        $profileId = isset($request->profile_id) ? $request->profile_id: $user->type_id;               
        $profileData = Profile::set($profileId)
            ->setDataBag('profile_data')
            ->getData($request);
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
        $user = AuthUser::findOrFail($id);

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