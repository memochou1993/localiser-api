<?php

namespace App\Http\Requests;

use App\Models\Language;
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

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $language_id = hash_id((new Language())->getTable())->decodeHex($this->input('language_id'));

        $this->merge([
            'language_id' => $language_id,
        ]);
    }
}
