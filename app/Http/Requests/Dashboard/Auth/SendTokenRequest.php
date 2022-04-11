<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendTokenRequest extends FormRequest
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
        $rules = ['send_type' => 'required|in:email,phone'];
        if($this->send_type == 'email'){
            $rules['email'] = 'required|email|exists:users,email,deleted_at,NULL';
        }elseif($this->send_type == 'phone'){
            $rules['phone'] = 'required|numeric|digits_between:5,20|exists:users,phone,deleted_at,NULL';
        }
        return $rules;
    }

    protected function prepareForValidation()
    {
        $data = $this->all();
        if ($this->has('phone')) {
            $this->merge([
                'phone' => @$data['phone'] && is_numeric($data['phone']) ? convert_arabic_number($data['phone']) : @$data['phone'],
                'send_type' => 'phone'
            ]);
        }else{
            $this->merge([
                'email' => @$data['email'],
                'send_type' => 'email'
            ]);
        }
    }

    public function attributes()
    {
        return [
            'phone' => trans('dashboard.general.phone'),
        ];
    }


}
