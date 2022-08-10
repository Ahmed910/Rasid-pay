<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;
use App\Models\Department\Department;

class DepartmentRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $igonredDepartment = $this->department ?  implode(',', Department::flattenChildren(
            Department::withTrashed()->findOrFail($this->department)
        )) : "";
        $rules = [
            "image"         => "nullable|max:1024|mimes:jpg,png,jpeg",
            "parent_id"     => "nullable|exists:departments,id,deleted_at,NULL|not_in:$igonredDepartment",
            "is_active"     => "in:0,1",
            'delete_image'  => "in:0,1"
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|min:2|max:100|regex:/^[\pL\pN\s\-\_]+$/u|unique:department_translations,name," . @$this->department  . ",department_id";
            $rules["$locale.description"]   = "nullable|string|max:300";
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'parent_id' =>  @$data['parent_id'] ?? null,
        ]);
    }

    public function messages()
    {
        return [

            app()->getLocale() . ".name.required"   => __('dashboard.department.validation.name.required'),
            app()->getLocale() . ".name.unique"     => __('dashboard.department.validation.name.unique'),
            app()->getLocale() . ".name.min"        => __('dashboard.department.validation.name.min'),
            app()->getLocale() . ".name.max"        => __('dashboard.department.validation.name.max'),
            app()->getLocale() . ".description.max" => __('dashboard.department.validation.description.max'),
            "image.max"                             => __('dashboard.department.validation.image.max'),
            "image.mimes"                           => __('dashboard.department.validation.image.mimes'),

        ];
    }
}
