<?php

namespace App\Http\Requests\Dashboard\RasidJobs;

use App\Http\Requests\ApiMasterRequest;

class FiltetJobsRequest extends ApiMasterRequest
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
        return [
            "name"=>"nullable|string|between:2,150",
            "department_id"=>"nullable|exists:departments,id,deleted_at,NULL",
            "from_date"=>"nullable|date|date_format:Y-m-d",
            "to_date"=>"nullable|date|date_format:Y-m-d|after:from_date",
            'is_active'=>'nullable|boolean',
            'is_vacant'=>'nullable|boolean',
        ];
    }
}
