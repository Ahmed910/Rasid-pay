<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Department\Department;

class DepartmentRequest extends ApiMasterRequest
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
        $igonredDepartment = $this->department ?  implode(',', Department::flattenChildren($this->department)) : "";
        $rules = [
            "image"         => "nullable|max:2048|mimes:dwg,jpg,png,jpeg",
            "parent_id"     => "nullable|exists:departments,id,deleted_at,NULL|not_in:$igonredDepartment",
            "is_active"     => "in:0,1"
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:department_translations,name," . $this->department?->id  . ",department_id";
            $rules["$locale.description"]   = "nullable|string||max:300";
        }

        return $rules;
    }
}
