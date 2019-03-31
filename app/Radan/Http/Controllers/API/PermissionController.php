<?php

namespace App\Radan\Http\Controllers\API;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Radan\Http\Controllers\APIController;
use App\Radan\Auth\Models\Permission;
use App\Radan\Resources\PermissionResource;
use App\Radan\Exceptions\ResourceProtected;

class PermissionController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        // Return 
        $count = Config::get('radan.pagination.count',15);   
        if ($count) {
            return PermissionResource::collection(Permission::paginate($count));
        }
        else {
            return PermissionResource::collection(Permission::all()); 
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
        // Validation permission
        Validator::make($request->only('name','display_name','description'), [
            'name' => 'required|string|max:255|unique:permissions',
            'display_name' => 'string|max:255',
            'description' => 'string|max:255',
        ])->validate();
    
        try {
			// Insert new permission
            $permission = new Permission();
            $profipermissionle = Permission::create([
                'name' => $request->name,        
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]);
		
			// Return
            return response()->json([
                'message' => __('app.insertAlert')],
                $this->httpCreated
            );
		}
		catch (Exceptions $e) {			
            return response()->json([
                'message' => 'Error create profile',
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
        return new PermissionResource(Permission::findOrFail($id));
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
        Validator::make($request->only('display_name','description'), [
            'description' => 'string|max:255',
            'display_name' => 'string|max:255',
        ])->validate();
        
		try {
            $permission = Permission::findOrFail($id);            
			$permission->update($request->only('display_name', 'description'));
            
            // Return
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );
		} catch (Exception $e) {
            return response()->json([
                'message' => 'Error update profile',
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
		// destroy permission
		$permission = Permission::findOrFail($id);		        

        // Get prevernts from config files
        $prevents = Config::get('radan.auth.prevents.permission');
        
        // Check prevents rule
        if (!is_null($prevents)) {
            foreach ($prevents as $key => $value) {
                if ($permission->$key==$value) {
                    throw new ResourceProtected;
                }
            }
        }

        // Destory profile
        $permission->delete();
        
        // Return
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
