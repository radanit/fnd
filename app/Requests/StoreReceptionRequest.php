<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Radan\Fundation\Traits\RadanRequestFilterTrait;

class StoreReceptionRequest extends FormRequest
{
    use RadanRequestFilterTrait;

    /**
     * Provide filter request after validation
     * 
     * @var array
     */
    protected $afterFilter = [
        'username' => 'set:national_id',
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
            'national_id' => 'required|digits:10|unique:users,username,'.$this->national_id.',username',
            'reception_date' => 'date',
            'doctor_id' => 'required|exists:users,id',
            'radio_type_id' => 'required|exists:radio_types,id',
        ];
    }    
}
