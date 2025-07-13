<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentFieldRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'document_type_id' => 'required',
            'field_name' => 'required|string',
            'field_label' => 'required|string',
            'field_type' => 'required|string',
            'is_required' => 'required|boolean',
            'order' => 'nullable|integer',
            'field_options' => 'nullable|string',
            'field_checkbox_options' => 'nullable|string',
            'hint' => 'nullable|string'
        ];
    }
}
