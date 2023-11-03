<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportMissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_mission_id' => 'required|exists:core_user_missions,id',
            'report_result' =>  ['required'],
            'report_result.link_report' => ['nullable','required_if:report_result.description,null', 'string', 'url'],
            'report_result.description' => ['nullable','required_if:report_result.link_report,null', 'string'],
            'report_result.image_url' => ['nullable', 'string']
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
