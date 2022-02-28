<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class RasidJobRequest extends ApiMasterRequest
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
        $rules = [
            "department_id" => "required|exists:departments,id",
            "is_active" => "boolean",
            "is_vacant" => "boolean",
            "added_by_id " => "nullable|exists:users,id",
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = "required|between:2,100|string|unique:rasid_job_translations,name," . @$this->rasid_job->id. ",rasid_job_id";
            $rules["$locale.description"]   = "nullable|string|max:300";
        }

        return $rules;
    }
}

