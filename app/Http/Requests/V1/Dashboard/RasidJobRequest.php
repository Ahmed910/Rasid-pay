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
            "department_id" => "nullable|exists:departments,id",
            "is_active" => "required|boolean",
            "is_vacant" => "required|boolean",
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = "required|max:255|string|unique:rasid_job_translations,name," . @$this->rasid_job->id. ",rasid_jobs_id";
            $rules["$locale.description"]   = "required|string";
        }

        return $rules;
    }
}

