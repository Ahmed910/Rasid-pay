<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class LocalizationRequest extends ApiMasterRequest
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
        return [
            "locale" => "required|in:ar,en|max:3|min:2",
            "key" => "required|exists:translations,key,id,".@$this->translation."|max:255",
            "value" => "required|max:255",
        ];
    }
}
