<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_am' => 'required|string',
            'description_en' => 'required|string',
            'attachments' => 'array'
        ];
    }
}
