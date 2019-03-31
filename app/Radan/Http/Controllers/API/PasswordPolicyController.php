<?php

namespace App\Radan\Http\Controllers\API;

// Laravel classis
use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// Base Application classes
use App\Radan\Http\Controllers\APIController;

// Radan modules classes
use App\Radan\Resources\PasswordPolicyResource;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;

// This Module classes
use App\Radan\Policy\Password\Models\PasswordPolicy;
use PasswordPolicy as Password;

class PasswordPolicyController extends APIController
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

        // Return Resource
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
        $passwordPolicy = new PasswordPolicy();
        
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191|unique:'.$passwordPolicy->getTable(),
            'description' => 'required|string|max:191',            
            'min_length' => 'bail|integer|min:6',
            'max_length' => 'bail|integer|gte:min_length',
            'upper_case' => 'bail|integer|lt:max_length',
            'lower_case' => 'bail|integer|lt:max_length',
            'digits' => 'bail|integer|lt:max_length',
            'special_chars' =>  'bail|integer|lt:max_length',
            'does_not_contain' => 'nullable|alpha_dash'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid',
                'errors' => $validator->errors()->first()],
                $this->httpUnprocessableEntity
            );
        }
                
        // Create Resource
        $password = $passwordPolicy->create(
            $request->only(
                'name',
                'description',
                'min_length','max_length','digits',
                'upper_case','lower_case',                
                'special_chars',
                'does_not_contain'
            )
        );
            
        return response()->json([
            'message' => __('app.insertAlert')],
            $this->httpCreated
        );
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
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:191',
            'min_length' => 'bail|integer|min:6',
            'max_length' => 'bail|integer|gte:min_length',
            'upper_case' => 'bail|integer|lt:max_length',
            'lower_case' => 'bail|integer|lt:max_length',
            'digits' => 'bail|integer|lt:max_length',
            'special_chars' =>  'bail|integer|lt:max_length',
            'does_not_contain' => 'nullable|alpha_dash'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid',
                'errors' => $validator->errors()->first()],
                $this->httpUnprocessableEntity
            );
        }
                
        $password = PasswordPolicy::findOrFail($id);
        $password->update($request->only(       
            'description',
            'min_length','max_length',
            'upper_case','lower_case',
            'special_chars',
            'does_not_contain'
        ));
                    
        return response()->json([
            'message' => __('app.updateAlert')],
            $this->httpOk
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find Resource
        $password = PasswordPolicy::findOrFail($id);
        
        // Get prevernts from config files        
        $prevents = Config::get('password_policy.prevents');
        
        // Check prevents rule
        if (!is_null($prevents)) {
            foreach ($prevents as $key => $value) {
                if ($password->$key==$value) {                        
                    throw new ResourceProtected;
                }
            }
        }        
            
        // Delete Resource
        $password->delete();
            
        // Return Response
        return response()->json([
            'message' => __('app.deleteAlert')],
            $this->httpOk
        );
    }
}
