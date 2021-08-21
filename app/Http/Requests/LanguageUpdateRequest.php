<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LanguageUpdateRequest extends FormRequest
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
        $language = $this->route('language');

        return [
            'name' => [
                'min:1',
                Rule::unique('languages', 'name')
                    ->where('project_id', $language->project->id)
                    ->ignore($language->id),
            ],
            'locale' => [
                'min:1',
                Rule::unique('languages', 'locale')
                    ->where('project_id', $language->project->id)
                    ->ignore($language->id),
            ],
        ];
    }
}
