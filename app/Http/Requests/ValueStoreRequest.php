<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValueStoreRequest extends FormRequest
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
            'language_id' => [
                'required',
                Rule::in($key->project->languages->pluck('id')),
                Rule::notIn($key->values->pluck('language_id')),
            ],
        ];
    }
}
