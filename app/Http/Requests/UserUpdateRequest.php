<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $user = $this->route('user');

        $allowedRoles = collect(config('roles'))
            ->where('scope', 'system')
            ->keys();

        return [
            'name' => [
                'min:1',
            ],
            'email' => [
                'email',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],
            'password' => [
                'min:8',
            ],
            'role' => [
                Rule::in($allowedRoles),
            ],
        ];
    }
}
