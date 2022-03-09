<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\RasidJob\RasidJob;

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
            "department_id" => "required|exists:departments,id,deleted_at,NULL,is_active,1",
            "is_active" => "boolean",
            "is_vacant" => "boolean",
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = ["required","regex:/^[\pL\pN\s\-\_]+$/u","between:2,100",function ($attribute, $value, $fail) use($locale){
                $job = RasidJob::whereTranslation('name',$value,$locale)->where('department_id',$this->department_id)->when($this->rasid_job,function ($q) {
                    $q->where('rasid_jobs.id',"<>",$this->rasid_job->id);
                })->count();
                if ($job) {
                    $fail(trans('dashboard.error.name_must_be_unique_on_department'));
                }

            }];
            $rules["$locale.description"]   = "nullable|string|max:300";
        }

        return $rules;
    }
}
