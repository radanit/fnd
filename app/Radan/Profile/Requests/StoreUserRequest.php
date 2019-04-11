<?php

namespace App\Radan\Profile\Requests;

// Laravel Libraries
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

// Radan Libraries
use App\Radan\Fundation\Traits\RadanRequestFilterTrait;
use Profile;
use PasswordPolicy;

class StoreUserRequest extends FormRequest
{
    use RadanRequestFilterTrait;

    /**
     * Provide filter request befor validation
     * 
     * @var array
     */
    protected $beforFilter = [
        'profile_data' => 'array',
        'roles' => 'array',
        'active' => 'boolean',
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
        if ($this->request->get('roles')) {
            if (in_array('admin',array_values($this->request->get('roles')) ))
            {
                return (auth()->user()->hasRole('admin')) ? true: false;
            }
        }
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
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|'.PasswordPolicy::getValidation('default'),
            'active' => 'required|boolean',
            'profile_id' => 'required|exists:'.Profile::getTable().',id',
            'profile_data' => 'array',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ];
    }    
}
