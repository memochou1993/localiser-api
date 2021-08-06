<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KeyUpdateRequest extends FormRequest
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
        $key = $this->route('key');

        return [
            'name' => [
                'min:1',
                Rule::unique('keys', 'name')
                    ->where('project_id', $key->project->id)
                    ->ignore($key->id),
            ],
        ];
    }
}
