<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreOutlet extends FormRequest
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
            'outlets_code' => 'required|unique:mch_outlets,outlets_code|min:3',
            'merchant_id' => 'required|numeric',
            'merchant_client_id' => 'required|numeric',
            'outlets_title' => 'required|min:3',
            'outlets_address_province_pid' => 'required|numeric',
            'outlets_address_city_pid' => 'required|numeric',
            'outlets_address_region_pid' => 'required|numeric',
            'outlets_auth_code' => 'required',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->sendValidationError($errors));
    }
}
