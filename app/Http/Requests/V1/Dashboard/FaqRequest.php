<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class FaqRequest extends ApiMasterRequest
{
    private array $rules = [];

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
       
        if (isset($this->faq) && $this->faq) {
            return array_merge($this->validateMainDataForFaq(), ['is_active' => 'required|in:0,1']);
        } else {
            return $this->validateMainDataForFaq();
        }
    }

    private function validateMainDataForFaq(): array
    {
        $this->rules = [
            'question' => 'required|string|between:5,1000',
            'order' => 'nullable|numeric',
            'answer' => 'required|string|between:5,10000'
        ];
        return $this->rules;
    }
}
