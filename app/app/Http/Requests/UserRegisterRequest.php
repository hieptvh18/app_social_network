<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
        return [
            'name'=>'required|min:6|max:30',
            'username'=>'required|unique:users|min:6|max:14|regex:/^\w{4,14}$/',
            'email'=>'required|email|unique:users',
            'password'=>'required|max:16'
        ];
    }

    public function messages()
    {
        return [
            'username.unique' => 'Username is exist!',
            'username.regex'=>'Username is not valid',
            'email.unique' => 'Email is exist!',
            'exists' => 'Not found user ID in database!'
        ];
    }

    public function attributes()
    {
        return [];
    }
}
