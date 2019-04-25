<?php

namespace Kiyon\Laravel\Menu\Request;

use Illuminate\Foundation\Http\FormRequest;
use Kiyon\Laravel\Support\Constant;

class MenuRequest extends FormRequest
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
            'parent_id'          => 'required|numeric' . (request('parent_id') == 0 ? '' : '|exists:sys_menus'),
            'key'                => 'required|alpha_dash|max:50',
            'display_name'       => 'sometimes|string|nullable|max:50',
            'type'               => 'required|in:' . implode(',', Constant::MENU_TYPE),
            'group'              => 'sometimes|boolean',
            'sort'               => 'sometimes|numeric',
            'link'               => 'required|max:255',
            'link_exact'         => 'sometimes|boolean',
            'external_link'      => 'sometimes|max:255',
            'target'             => 'sometimes|in:_blank,_self,_parent,_top',
            'hide'               => 'sometimes|boolean',
            'hide_in_breadcrumb' => 'sometimes|boolean',
            'shortcut'           => 'sometimes|boolean',
            'shortcut_root'      => 'sometimes|boolean',
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
            'parent_id'          => 'sometimes|numeric' . (request('parent_id') == 0 ? '' : '|exists:sys_menus'),
            'key'                => 'sometimes|alpha_dash|max:50',
            'display_name'       => 'sometimes|string|nullable|max:50',
            'type'               => 'sometimes|in:' . implode(',', Constant::MENU_TYPE),
            'group'              => 'sometimes|boolean',
            'sort'               => 'sometimes|numeric',
            'link'               => 'sometimes|min:1|max:255',
            'link_exact'         => 'sometimes|boolean',
            'external_link'      => 'sometimes|max:255',
            'target'             => 'sometimes|in:_blank,_self,_parent,_top',
            'hide'               => 'sometimes|boolean',
            'hide_in_breadcrumb' => 'sometimes|boolean',
            'shortcut'           => 'sometimes|boolean',
            'shortcut_root'      => 'sometimes|boolean',
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
