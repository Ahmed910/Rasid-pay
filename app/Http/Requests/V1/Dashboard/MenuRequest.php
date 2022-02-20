<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class menuRequest extends ApiMasterRequest
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
            'order' => 'required|integer|gt:0',
            'menu_type' => 'required|in:erp_dashboard,client_dashboard',
            'icon' => 'nullable|string',
            'parent_id' => 'nullable|exists:menus,id',
            'uri' => 'required|string'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.name'] = 'required|max:255|unique:menu_translations,name,' . @$this->menu->id . ',menu_id';
        }

        return $rules;
    }
}
