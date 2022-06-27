<?php

namespace App\Http\Requests\Dashboard\Auth;

use App\Http\Requests\ApiMasterRequest;
use App\Models\User;

class CheckSmsCodeLoginRequest extends ApiMasterRequest
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
        // dd($this->login_code);
           return [
           'reset_token' => 'required|exists:users,reset_token,ban_status,active',
           'login_code' => 'required|min:4|exists:users,login_code,deleted_at,NULL'
       ];
   }

   protected function prepareForValidation()
   {
       $data = $this->all();

       $this->merge([
           'login_code' => @$data['login_code'] ? implode('',$data['login_code']) : null
       ]);
   }

   public function messages()
   {
       return [
           'login_code.exists' => trans('dashboard.general.invalid_code'),
       ];
   }
}
