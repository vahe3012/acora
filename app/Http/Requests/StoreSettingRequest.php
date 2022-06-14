<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
            'attachments' => 'nullable|array',
            'title' => 'nullable|string|max:255',
            'key' => 'nullable|string|max:255',
            'value' => 'nullable|array|max:255',
            'type' => 'nullable|string|max:255',

        ];
    }
}
