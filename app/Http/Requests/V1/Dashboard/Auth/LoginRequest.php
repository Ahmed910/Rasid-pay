<?php

namespace App\Http\Requests\V1\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;

class LoginRequest extends ApiMasterRequest
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
          'username' => 'required',
          'password' => 'required',
          'device_token' => 'required|string|between:2,10000',
          'device_type' => 'required|in:ios,android',
        ];
    }

    public function getValidatorInstance()
    {
       $data = $this->all();
       if (isset($data['username']) && is_numeric($data['username'])) {
           $data['username'] = convert_arabic_number($data['username']);
       }
       $this->getInputSource()->replace($data);
       return parent::getValidatorInstance();
    }

}
