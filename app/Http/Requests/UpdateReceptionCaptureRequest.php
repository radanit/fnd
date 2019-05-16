<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceptionCaptureRequest extends FormRequest
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
            'graphy_jpg.*' => 'nullable|image',            
            'graphy_dicom' => 'nullable|image',
            'graphy_result' => 'nullable|string'
        ];
    }    
}
