<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:core_blog_categories,name,' . $this->id,
            'description' => 'nullable',
            'is_active' => 'required',
            'is_show_homepage' => 'required',
            'image' => ['required','string','regex:/\.(jpg|jpeg|png|webp|avif|gif|svg)$/']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
