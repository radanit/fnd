<?php

namespace App\Radan\Auth\Controllers;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\Permission;
use App\Radan\Resources\PermissionResource;
use App\Radan\Exceptions\ResourceProtected;

class PermissionController extends Controller
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
        Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions',
            'description' => 'string|max:255',
            'displayname' => 'string|max:255',
        ])->validate();
    
        try {
			// Insert new permission
			$permission = new Permission();
			$permission->name = $request->name;
			$permission->display_name = $request->displayname; // optional
			$permission->description = $request->description; // optional
			$permission->save();
			
			// Return
			return response()->json(['message' => __('app.insertAlert') ], 200);
		}
		catch (Exceptions $e) {
			Log::error($e->getMessage());
			// Return
			return response()->json(['message' => 'Error insert permmision' , 'errors' => __('app.failedAlert') ], 500);
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
        Validator::make($request->all(), [
            'description' => 'string|max:255',
            'display_name' => 'string|max:255',
        ])->validate();
        
		try {
			$permission = Permission::findOrFail($id);
			$permission->update($request->only('description', 'display_name'));
			return response()->json(['message' => __('app.updateAlert') ], 200);
		} catch (Exception $e) {						
			Log::error($e->getMessage());
			return response()->json(['message' => 'Error update permission' , 'errors' => __('app.failedAlert') ], 500);
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
		// destroy profile
		$permission = Permission::findOrFail($id);
		$permission->delete();
		return response()->json(['message' => __('app.deleteAlert') ], 200);
    }
}
