<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class UpdateCitizenStatusRequest extends ApiMasterRequest
{

     /**
      * Get the validation rules that apply to the request.
      *
      * @return array
      */
     public function rules()
     {
         return [
             "ban_status" => "required|in:active,temporary,permanent,exceeded_attempts"
         ];
     }
}
