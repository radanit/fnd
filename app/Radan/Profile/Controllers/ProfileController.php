<?php

namespace App\Radan\Profile\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Radan\Profile\Models\Profile;
use App\Radan\Resources\ProfileResource;
use App\Radan\Exceptions\ResourceProtected;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;

class ProfileController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // Return 
    return ProfileResource::collection(Profile::paginate());
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
      'name' => 'required|string|max:255|unique:profiles',
      'description' => 'required|string|max:255',
      'structure' => 'required|json',
    ])->validate();

    $profile = Profile::create([
      'name' => $request->name,        
      'description' => $request->description,
      'structure' => $request->structure,
    ]);

    return new ProfileResource($profile);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return new ProfileResource(Profile::findOrFail($id));        
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(ProfileRequest $request, $id)
  {        
    // Validation rules
    Validator::make($request->only('description','structure'), [        
        'description' => 'string|max:255',
        'structure' => 'required|json',
    ])->validate();
    
    $profile = Profile::findOrFail($id);
    $profile->update($request->only(['description', 'structure']));

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
      
      // destroy profile
      $profile = Profile::findOrFail($id);

      // get prevernts from config files
      $prevents = Config::get('radan.profile.prevents.profiles');

      // Check prevents rule
      foreach ($prevents as $key => $value) {
        if ($profile->$key==$value) {          
          throw new ResourceProtected;
        }
      }
      
      $profile->delete();      
    }
}
