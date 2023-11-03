<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:core_blogs,name',
            'alias' => ['required', 'max:255', 'regex:/^([a-z0-9-]*)$/'],
            'short_description' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image_thumbnail' => ['required', 'regex:/\.(jpg|jpeg|png|gif)$/'],
            'image_cover' => ['required', 'regex:/\.(jpg|jpeg|png|gif)$/'],
            'type' => 'required|in:STATIC,NORMAL',
            'published_at' => 'date',
            'finished_at' => 'nullable|date',
            'status' => 'required|in:PUBLISHED,DRAFT,ARCHIVE',
            'show_type' => 'in:WEB,MOBILE',
            'action_click_type' => 'in:NORMAL,OPEN_BLANK',
            'is_featured' => 'required',
            'bizapp' => 'in:EDUQUIZ,CRM',
            'tag_ids' => 'array',
            'tag_ids.*' => 'integer',
            'category_ids' => 'array',
            'category_ids.*' => 'integer'
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
