<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'file' => ($this->isMethod('put') ? 'nullable' : 'required') . '|file|mimes:jpeg,png,gif,doc,docx,pdf,txt,zip,pptx|max:2048'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => ':attribute required.',
            'file.max' => ':attribute too big'
        ];
    }
}
