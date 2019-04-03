<?php

namespace App\Radan\Profile\Requests;

// Laravel Libraries
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

// Radan Libraries
use App\Radan\Fundation\Traits\RadanRequestFilter;
use Profile;
use PasswordPolicy;

class UpdateUserRequest extends FormRequest
{
    use RadanRequestFilter;

    /**
     * Provide filter request befor validation
     * 
     * @var array
     */
    protected $beforFilter = [
        'username' => 'remove',
        'password' => 'unsetIfNull',
        'active' => 'boolean',
        'profile_data' => 'array',
        'roles' => 'array',        
    ];

    /**
     * Provide filter request after validation
     * 
     * @var array
     */
    protected $afterFilter = [        
    ];
    
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
