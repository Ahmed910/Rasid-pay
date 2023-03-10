<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class OurAppRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $image = 'required|mimes:jpg,jpeg,png,gif,svg|max:5120';
        if($this->our_app){
            $image = 'nullable|mimes:jpg,jpeg,png,gif,svg|max:5120';
        }
        $rules = [
            'order' => 'nullable|numeric|gt:0',
            'android_link' =>'required|active_url',
            'ios_link' => 'required|active_url',
            'image' => $image,
            'is_active' => 'required|in:0,1'

        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale"]               = "array";
            $rules["$locale.name"]          = "required|between:2,100|regex:/^[\pL\pN\s\-\_]+$/u|unique:our_app_translations,name," . @$this->our_app  . ",our_app_id";
            $rules["$locale.description"]   = "nullable|string|max:300";
        }
        // dd($rules);

        return $rules;
    }

    public function messages()
    {
        $validation = 'dashboard.our_app.validation';

        $validation_messages = [

            'order.numeric' => trans($validation.'.order.numeric'),
            'android_link.required' => trans($validation.'.android_link.required'),
             'ios_link.required' => trans($validation.'.ios_link.required'),
             'image.image' => trans($validation.'.image.image'),
            'image.mimes' => trans($validation.'.image.mimes'),
            'image.max' => trans($validation.'.image.max',['max'=>'5120']),
            'is_active.required' => trans($validation.'.is_active.required'),
            'is_active.in' => trans($validation.'.is_active.in')

        ];
        foreach (config('translatable.locales') as $locale) {
            $validation_messages["$locale.name.required"]  = trans("$validation.$locale.name.required");
            $validation_messages["$locale.name.string"]  = trans("$validation.$locale.name.string");
            $validation_messages["$locale.name.between"]  = trans("$validation.$locale.name.between",['min'=>'2','max'=>'100']);
            $validation_messages["$locale.name.unique"]  = trans("$validation.$locale.name.unique");
            $validation_messages["$locale.description.string"]  = trans("$validation.$locale.description.string");
            $validation_messages["$locale.description.max"]  = trans("$validation.$locale.description.max",['max'=>'300']);
        }


        return $validation_messages;
    }
    }

