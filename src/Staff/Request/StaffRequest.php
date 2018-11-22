<?php

namespace Kiyon\Laravel\Staff\Request;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'username'     => 'sometimes|max:50|alpha_dash|unique:sys_users',
            'display_name' => 'sometimes|nullable|string|max:50',
            'mobile'       => 'required|min:8|unique:sys_users',
            'email'        => 'sometimes|email|unique:sys_users',
            'password'     => 'required|max:50',
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
            'username'     => 'sometimes|string|unique:sys_users',
            'display_name' => 'sometimes|string|max:50',
            'mobile'       => 'sometimes|min:8|unique:sys_users',
            'email'        => 'sometimes|email|unique:sys_users',
            'password'     => 'sometimes|max:50',
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
