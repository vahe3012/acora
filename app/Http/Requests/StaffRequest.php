<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'fullname_am' => 'required|string',
            'fullname_en' => 'required|string',
            'position_am' => 'required|string',
            'position_en' => 'required|string',
            'description_am' => 'required|string',
            'description_en' => 'required|string',
            'attachment_id' => 'required|numeric'
        ];
    }
}
