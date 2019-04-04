<?php

namespace Kiyon\Laravel\Authentication\Request;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case FormRequest::METHOD_POST:
                return $this->storeRules();
            case FormRequest::METHOD_PATCH:
                return $this->updateRules();
            case FormRequest::METHOD_PUT:
                return $this->updateRules();
            default:
                return [];
        }
    }

    /**
     * Get the validation rules that apply to the store request.
     *
     * @return array
     */
    private function storeRules()
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * Get the validation rules that apply to the update request.
     *
     * @return array
     */
    private function updateRules()
    {
        return [

        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}
