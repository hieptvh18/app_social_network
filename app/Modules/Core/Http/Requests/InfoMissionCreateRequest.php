<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use Modules\Core\Enums\InfoMissionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InfoMissionCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method_approval_type = $this->input('method_approval_type');
        return [
            'name' => 'required|string|min:2',
            'description' => 'nullable|string|min:2',
            'assign_user_type' => 'in:AUTO,MANUAL,PROMOTION',
            'reward_type' => ['required', 'in:REWARD_POINT,GIFT'],
            'apply_entity_type' => 'in:EXAM,DOCUMENT,USER',
            'method_reward_point_type' => ['required_if:reward_type,REWARD_POINT', new Enum(InfoMissionEnum::class)],
            'reward_point_condition_number' => 'required_if:reward_type,REWARD_POINT|integer',
            'method_approval_type' => 'required|in:AUTO,MANUAL',
            'reward_point' => 'required_if:reward_type,REWARD_POINT|integer',
            'expired_time_type' => 'nullable|in:DAY,HOUR,MINUTE',
            'expired_time_after' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'guilde_report_description' => [Rule::requiredIf(function () use ($method_approval_type) {
                return $method_approval_type === 'MANUAL';
            }), 'string', 'nullable'],
            'apply_start_date' => ['required'],
            'apply_end_date' => ['nullable'],

            'banner_url' => 'required_if:assign_user_type,PROMOTION',
            'gift_id' => 'nullable|required_if:reward_type,GIFT|exists:core_mission_gift,id',
            'image_url' => 'nullable|required_if:assign_user_type,PROMOTION'
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
