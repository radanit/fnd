<?php

namespace App\Radan\Auth\Controllers;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\Role;
use App\Radan\Resources\RoleResource;
use App\Radan\Exceptions\ResourceProtected;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {                
        // Get number of pagination count
        $count = Config::get('radan.pagination.count',15);   

        // Return 
        if ($count) {
            return RoleResource::collection(Role::paginate($count));
        }
        else {
            return RoleResource::collection(Role::all()); 
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
        // Validation rules
        Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'string|max:255',
            'display_name' => 'string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',

        ])->validate();
    
        // Begin Database transaction			
        DB::beginTransaction();
        try {
            // First create role in roles table     
            $role = Role::create([
                'name' => $request->name,        
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]);

            // Find permission and assigned to role
            $permissions = is_array($request->permissions) ? $request->permissions: explode(',',$request->permissions);
            $role->attachPermissions($permissions);
            
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
                'message' => 'Error create permission',
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
        //
        return new RoleResource(Role::findOrFail($id));
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
        // Validation permission   
        Validator::make($request->only('display_name','description','permissions'), [
            'description' => 'string|max:255',
            'display_name' => 'string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ])->validate();
        
        try {
            $role = Role::findOrFail($id);
            $role->update($request->only('description', 'display_name'));
            
            // Set role permissions and update
            if ($request->filled('permissions')) {
				$role->syncPermissions($request->permissions);
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
                'message' => 'Error update role',
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
        // Find role by id        
        $role = Role::findOrFail($id);

        try {        

            // Get prevernts from config files
            $prevents = Config::get('radan.auth.prevents.role');
            
            // Check prevents rule
            if (!is_null($prevents)) {
                foreach ($prevents as $key => $value) {
                    if ($role->$key==$value) {
                        throw new ResourceProtected;
                    }
                }
            }
            
            // deattach all permmisions
            $role->syncPermissions([]);            

            // delete user
            $role->delete();        
            
            /// Return
            return response()->json([
                'message' => __('app.deleteAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {        
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Error delete role',
                'errors' => __('app.failedAlert')],
                $this->httpInternalServerError
            );
        }        
    }
}
