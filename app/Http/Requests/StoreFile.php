<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFile extends FormRequest
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
            'isTitlePage' => 'sometimes|accepted',
            'isToc' => 'sometimes|accepted',
            'isTocOwnPage' => 'sometimes|accepted',
            'isLinksAsNotes' => 'sometimes|accepted',
            'title' => 'required|string|max:100',
            'subtitle' => 'required|max:100',
            'school' => 'present|max:100',
            'date' => 'required|date_format:"d/m/Y"',
            'fileContent' => 'required|string',
            'right' => ['required','string',Rule::in(['private','readable','editable'])],
            'newFolder' => 'required|integer',
        ];
    }
}
