<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Department\Department;

class DepartmentRequest extends FormRequest
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
            "image"         => "nullable|max:5120|mimes:jpg,png,jpeg",
            "parent_id"     => "nullable|exists:departments,id,deleted_at,NULL|not_in:$igonredDepartment",
            "is_active"     => "in:0,1",
            'delete_image'  => "in:0,1"
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:department_translations,name," . $this->department?->id  . ",department_id";
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
}