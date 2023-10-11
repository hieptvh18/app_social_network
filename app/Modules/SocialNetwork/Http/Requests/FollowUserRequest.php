<?php

namespace Modules\SocialNetwork\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FollowUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'following_id' => [
                'required',
                'exists:users,id',
                Rule::unique('follows')->where(function ($query) {
                    return $query->where('user_id', $this->input('user_id'));
                })
            ],
        ];
    }
}
