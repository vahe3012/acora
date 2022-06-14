<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
            'activity_am' => 'required|string',
            'activity_en' => 'required|string',
            'objectives_am' => 'required|string',
            'objectives_en' => 'required|string',
            'management_am' => 'required|string',
            'management_en' => 'required|string',
            'history_am' => 'required|string',
            'history_en' => 'required|string',
            'founding_documents.attachment_id' => 'required|numeric',
            'founding_documents.attachment_title_am' => 'required|string',
            'founding_documents.attachment_title_en' => 'required|string'
        ];
    }
}
