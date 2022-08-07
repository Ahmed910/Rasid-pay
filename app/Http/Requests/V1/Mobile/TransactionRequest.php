<?php

namespace App\Http\Requests\V1\Mobile;

use App\Http\Requests\ApiMasterRequest;

class TransactionRequest extends ApiMasterRequest
{
    public function rules()
    {
        return [
            'created_from' => 'date',
            'created_to'   => 'date|after_or_equal:created_from',
        ];
    }


    public function messages()
    {
       return [
        'created_to.after_or_equal' => __('mobile.validation.transaction.after_or_equal')
       ];
    }
}
