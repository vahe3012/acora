<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'main_image' => 'required|numeric|required',
            'categories' => 'required|array|required',
            'title_am' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_am' => 'string|required',
            'content_en' => 'string|required',
            'excerpt_am' => 'string|required',
            'excerpt_en' => 'string|required',
            'date' => 'nullable|date'
        ];
    }
}
