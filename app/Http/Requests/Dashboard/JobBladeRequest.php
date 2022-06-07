<?php

namespace App\Http\Requests\Dashboard;

use App\Models\RasidJob\RasidJob;
use Illuminate\Foundation\Http\FormRequest;

class JobBladeRequest extends FormRequest
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
            "department_id" => "required|exists:departments,id,deleted_at,NULL",
            "is_vacant" => "in:1,0",
        ];
         if ($this->rasid_job) {
             $job = RasidJob::withTrashed()->findOrFail($this->rasid_job) ;
             if($job->is_vacant) $rules+=["is_active"=>"in:0,1"];
             else {if ($this->is_active!=$job->is_active)
                 $rules+=["is_active" => function ($attribute, $value, $fail) {
                     $fail(trans("dashboard.rasid_job.jobs_hired_is_active_changed"));
                 } ] ;
             }
         }
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = ["required","regex:/^[\pL\pN\s\-\_]+$/u","between:2,100",function ($attribute, $value, $fail) use($locale){
                $job = RasidJob::whereTranslation('name',$value,$locale)->where('department_id',$this->department_id)->when($this->rasid_job,function ($q) {
                    $q->where('rasid_jobs.id',"<>",$this->rasid_job);
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
