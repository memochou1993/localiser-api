<?php

namespace App\Http\Requests;

use App\Constants\Scope;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
        $allowedRoles = collect(config('roles'))
            ->where('scope', Scope::SYSTEM)
            ->keys();

        return [
            'name' => [
                'required',
            ],
            'email' => [
                'email',
                'required',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'min:8',
                'required',
            ],
            'role' => [
                'required',
                Rule::in($allowedRoles),
            ],
        ];
    }
}
