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
        if (request()->isJson()) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'message' => trans('dashboard.error.something_went_wrog'),
                'errors' => request()->is("*/dashboard/*") ? $validator->errors()->toArray() : $validator->errors()->first(),
                'data' => null,
            ], 422));
        }
    }
}
