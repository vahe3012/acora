<?php

namespace App\Http\Requests;

use App\Models\Law;
use Illuminate\Foundation\Http\FormRequest;

class LawRequest extends FormRequest
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
            'type' => 'required|string',
            'link' => 'url|required_if:type,' . Law::TYPE_LAW,
            'attachment_id' => 'numeric|required_if:type,' . Law::TYPE_REGULATION,
        ];
    }
}
