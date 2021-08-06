<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class LanguageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('view', $this->route('project'))->allowed();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $project = $this->route('project');

        return [
            'name' => [
                'required',
                Rule::unique('languages', 'name')
                    ->where('project_id', $project->id),
            ],
            'code' => [
                'required',
                Rule::unique('languages', 'code')
                    ->where('project_id', $project->id),
            ],
        ];
    }
}
