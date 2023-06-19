<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username'=>'required|unique:users'
        ];
    }

    public function messages(){
        return [
            'required'=>'Bat buoc nhap field!',
            'unique'=>'User da ton tai!'
        ];
    }

    public function attributes()
    {
        return [];
    }
}
