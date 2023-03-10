<?php

namespace App\Http\Requests\Mobile;

use App\Http\Requests\ApiMasterRequest;

class ActivateNotificationRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'is_notification_enabled' => 'required|in:0,1',
        ];
    }


}
