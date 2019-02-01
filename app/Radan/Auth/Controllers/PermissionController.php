<?php

namespace App\Radan\Auth\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\Permission;
use App\Radan\Resources\PermissionResource;
use App\Radan\Exceptions\ResourceProtected;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;

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
        //
        // Validation rules
        Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions',
            'description' => 'string|max:255',
            'displayname' => 'string|max:255',
        ])->validate();
    
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->display_name = $request->displayname; // optional
        $permission->description = $request->description; // optional
        $permission->save();     
  
        return new PermissionResource($permission);
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
        //
        // Validation rules   
        Validator::make($request->all(), [
            'description' => 'string|max:255',
            'displayname' => 'string|max:255',
        ])->validate();
        
        $permission = Permission::findOrFail($id);
        $permission->update($request->only(['description', 'displayname']));

        return new PermissionResource($permission);
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

      // get prevernts from config files
      // $prevents = Config::get('radan.profile.prevents.profiles');

      // Check prevents rule
      /*
      foreach ($prevents as $key => $value) {
        if ($profile->$key==$value) {          
          throw new ResourceProtected;
        }
      }
      */
      $permission->delete();
    }
}
