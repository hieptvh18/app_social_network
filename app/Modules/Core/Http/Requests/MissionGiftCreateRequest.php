<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MissionGiftCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'thumbnail_url' => 'nullable|string',
            'type' => 'required|in:PLAN_VIP,MOBILE_CARD,MONEY',
            'exchange_point' => 'integer',
            'allow_exchange_many' => 'boolean',
            'exchange_qty' => 'integer',
            'apply_start_date' => 'required',
            'apply_end_date' => 'nullable',
            'is_active' => 'boolean'
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
