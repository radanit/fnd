<?php

namespace App\Radan\Profile\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceptionRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */    
    public function rules()
    {
        return [
            'email' => 'email|max:255|unique:users,email,'.$this->user.',id',                       
            'password' => 'nullable|confirmed|'.PasswordPolicy::getValidation('default'),
            'active' => 'boolean',
            'profile_id' => 'exists:'.Profile::getTable().',id',
            'profile_data' => 'array',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ];        
    }
}
