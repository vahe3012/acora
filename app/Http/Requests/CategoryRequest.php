<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
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
        if (strstr(url()->previous(), 'update')) {
            $slugRule = 'required|unique:categories,slug,'.$this->category->id.'|string|max:255';
        } else {
            $slugRule = 'required|unique:categories|string|max:255';
        }

        return [
            'slug' => $slugRule,
            'title_en' => 'string|max:255|required',
            'title_am' => 'string|max:255|required'
        ];
    }
}
