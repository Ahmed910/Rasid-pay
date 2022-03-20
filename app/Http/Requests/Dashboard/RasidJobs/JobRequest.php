<?php

namespace App\Http\Requests\Dashboard\RasidJobs;

use App\Http\Requests\ApiMasterRequest;

class JobRequest extends ApiMasterRequest
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
            'department_id' => 'required|exists:departments,id,deleted_at,NULL',
            'is_active'=>'required|boolean'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.name'] = 'required|string|between:2,250';
            $rules[$locale.'.description'] = 'nullable|string|between:5,100000';
        }

       return $rules;
    }
}
