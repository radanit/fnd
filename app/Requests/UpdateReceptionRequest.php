<?php

namespace App\Requests;

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
            'national_id' => 'required|digits:10|unique:users,username',
            'reception_date' => 'date',            
            'radio_type_id' => 'required|exists:radio_types,id',
        ];
    }    
}
