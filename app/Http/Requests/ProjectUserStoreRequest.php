<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProjectUserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::authorize('update', $this->route('project'))->allowed();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $allowedRoles = collect(config('roles'))
            ->where('scope', 'project')
            ->keys();

        return [
            'users' => [
                'array',
                'required',
            ],
            'users.*.id' => [
                'required_with:users',
                Rule::exists('users'),
            ],
            'users.*.role' => [
                'required',
                Rule::in($allowedRoles),
            ],
        ];
    }
}
