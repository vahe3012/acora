<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|',
            'message' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('main.contact.form.validation.name'),
            'email.required' => __('main.contact.form.validation.email'),
            'message.required' => __('main.contact.form.validation.message'),
        ];
    }
}
