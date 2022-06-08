<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiMasterRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        if(request()->wantsJson())
        {
            if (auth()->check() && auth()->user()->user_type != 'citizen') {
                $data = [
                    'message' => trans('dashboard.error.something_went_wrong'),
                    'errors' => request()->is("*/dashboard/*") ? $validator->errors()->toArray() : $validator->errors()->first(),
                ];
            }else{
                $data = [
                    'message' =>  $validator->errors()->first(),
                ];
            }
            throw new HttpResponseException(response()->json([
                'status' => false,
                'data' => null,
            ] + $data, 422));
        }
    }
}
