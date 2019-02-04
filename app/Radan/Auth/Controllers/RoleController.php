<?php

namespace App\Radan\Auth\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Radan\Auth\Models\Role;
use App\Radan\Resources\RoleResource;
use App\Radan\Exceptions\ResourceProtected;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;

class RoleController extends Controller
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
        //
        // Validation rules
        Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'string|max:255',
            'displayname' => 'string|max:255',
        ])->validate();
    
        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->displayname; // optional
        $role->description = $request->description; // optional
        $role->save();     
  
        return new RoleResource($role);
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
        //
        // Validation rules   
        Validator::make($request->all(), [
            'description' => 'string|max:255',
            'displayname' => 'string|max:255',
        ])->validate();
        
        $role = Role::findOrFail($id);
        $role->update($request->only(['description', 'displayname']));

        return new RoleResource($role);
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
      $role = Role::findOrFail($id);

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
      $role->delete();
    }
}
