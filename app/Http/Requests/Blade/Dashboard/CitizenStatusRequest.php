<?php

namespace App\Http\Requests\Blade\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CitizenStatusRequest extends FormRequest
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

     public function rules()
     {
         return [
             "ban_status" => "required|in:active,temporary,permanent,exceeded_attempts",
             'ban_from' => 'nullable|required_if:ban_status,temporary|date|after:1900-01-01|before:ban_to',
             'ban_to' => 'nullable|required_if:ban_status,temporary|date|after_or_equal:ban_from|after:yesterday',
         ];
     }
}
