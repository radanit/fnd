<?php

namespace App\Radan\Profile\Controllers;

use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Radan\Profile\Models\PasswordPolicy;
use App\Radan\Resources\PasswordPolicyResource;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;

class PasswordPolicyController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // Return
        $count = Config::get(
            'radan.profile.models.pagination.count', 
            Config::get('radan.pagination.count',15)
        );
        
        if ($count) {
            return PasswordPolicyResource::collection(PasswordPolicy::paginate($count));
        }
        else {
            return PasswordPolicyResource::collection(PasswordPolicy::all()); 
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
        // Read password policy table name form config
        $passwordPolicyTable = Config::get('radan.profile.tables.password_policies','password_policies');        
        
        // Validation rules
        Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:'.$passwordPolicyTable,
            'description' => 'required|string|max:255',
            'min_length' => 'integer',
            'max_length' => 'integer|gte:min_length',
            'upper_case' => 'integer',
            'lower_case' => 'integer',
            'digits' => 'integer',
            'special_chars' => 'integer',
            'does_not_contain' => 'string|max:255',
        ])->validate();

        // Create PasswordPolicy
        try {                        
            $passwordPolicy = PasswordPolicy::create([
                'name' => $request->name,
                'description' => $request->description,
                'min_length' => $request->min_length,
                'max_length' => $request->max_length,
                'upper_case' => $request->upper_case,
                'lower_case' => $request->lower_case,
                'digits' => $request->digits,
                'special_chars' => $request->special_chars,
                'does_not_contain' => $request->does_not_contain
            ]);

            // Return
            return response()->json([
                'message' => __('app.insertAlert')],
                $this->httpCreated
            );

        } catch (Exception $e) {           
            return response()->json([
                'message' => 'Error create PasswordPolicy',
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
        return new PasswordPolicyResource(PasswordPolicy::findOrFail($id));        
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
        // Validation rules   
        Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'min_length' => 'integer',
            'max_length' => 'integer',
            'upper_case' => 'integer',
            'lower_case' => 'integer',
            'digits' => 'integer',
            'special_chars' => 'integer',
            'does_not_contain' => 'string',
        ])->validate();

        try {            
            $PasswordPolicy->update($request->only(
                    'name',
                    'description',
                    'min_length',
                    'max_length',
                    'upper_case',
                    'lower_case',
                    'digits',
                    'special_chars',
                    'does_not_contain'
            ));
            
            // Return
            return response()->json([
                'message' => __('app.updateAlert')],
                $this->httpOk
            );

        } catch (Exception $e) {            
            return response()->json([
                'message' => 'Error update PasswordPolicy',
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
        // destroy PasswordPolicy
        $passwordPolicy = PasswordPolicy::findOrFail($id);
       
        // Get prevernts from config files
        $prevents = Config::get('radan.profile.prevents.password_policies');

        // Check prevents rule
        if (!is_null($prevents)) {
            foreach ($prevents as $key => $value) {
                if ($passwordPolicy->$key==$value) {
                    throw new ResourceProtected;
                }
            }
        }

        // Destory PasswordPolicy
        $passwordPolicy->delete();
            
        // Return
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
