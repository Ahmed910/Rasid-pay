<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class NotificationRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'body' => 'required|string|min:2|max:255',
            'type' => 'required|in:admin,client',
            'user_list' => 'nullable|array',
            'user_list.*' => 'nullable|exists:users,id',
        ];
    }
}
