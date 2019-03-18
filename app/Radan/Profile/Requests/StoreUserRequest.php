<?php

namespace App\Radan\Profile\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PasswordPolicy;

class StoreUserRequest extends FormRequest
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
        $this->filter();
        $filter = [
            'active' => 'boolean',
            'profile_data' => 'array',
            
        ]
        $profileTable = config('profile.tables.profile','profiles');
        return [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|'.PasswordPolicy::getValidation('default'),
            'active' => 'required|boolean',
            'profile_id' => 'required|exists:'.$profileTable.',id',
            'profile_data' => 'json',
            'roles' => 'json',
            'roles.*' => 'exists:roles,id',
        ];
    }

    protected function filter()
    {
        $this->request->replace(array_merge($request->request->all(), $newData));
    }
}
