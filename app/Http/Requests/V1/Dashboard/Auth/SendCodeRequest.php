<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class SendCodeRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ['send_type' => 'required|in:email,phone'];
        if($this->send_type == 'email'){
            $rules['username'] = 'required|email|exists:users,email,deleted_at,NULL';
        }elseif($this->send_type == 'phone'){
            $rules['username'] = 'required|numeric|digits_between:5,20|exists:users,phone,deleted_at,NULL';
        }
        return $rules;
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        $this->merge([
            'username' => @$data['username'] && is_numeric($data['username']) ? convert_arabic_number($data['username']) : @$data['username']
        ]);
    }

}
