<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UpdateClient extends FormRequest
{
    use \App\Http\Controllers\Contract\ResponseTrait;
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
        return [
            'client_category_pid' => 'required|numeric',
            'client_name' => 'required|min:3',
            'client_billing_address_line_1' => 'required|min:3',
            'client_billing_address_state_province_pid' => 'required|numeric',
            'client_billing_address_city_pid' => 'required|numeric',
            'client_billing_address_postal_code' => 'required|numeric',
            'client_industry_category_pid' => 'required|numeric',
            'client_employee_size_category_pid' => 'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->sendValidationError($errors));
    }
}
