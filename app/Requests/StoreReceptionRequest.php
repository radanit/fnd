<?php

namespace App\Radan\Profile\Requests;

// Laravel Libraries
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

// Radan Libraries
use App\Radan\Fundation\Traits\RadanRequestFilterTrait;
use Profile;
use PasswordPolicy;

class StoreReceptionRequest extends FormRequest
{
    use RadanRequestFilterTrait;

    /**
     * Provide filter request befor validation
     * 
     * @var array
     */
    protected $beforFilter = [        
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
            'national_id' => 'required|string|max:255|unique:users,username',
            'reception_date' => 'required|exists:'.Profile::getTable().',id',
            'doctor_id' => 'required|string|max:255|unique:users,username',
            'radio_type_id' => 'required|exists:radio_types',
        ];
    }    
}
