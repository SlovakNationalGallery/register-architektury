<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeaturedProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'menu_item_1_title' => 'exclude_if:locale,en|required',
            'menu_item_2_title' => 'exclude_if:locale,en|required',
            'menu_item_3_title' => 'exclude_if:locale,en|required',
            'menu_item_4_title' => 'exclude_if:locale,en|required',
            'menu_item_1_project_id' => 'required',
            'menu_item_2_project_id' => 'required',
            'menu_item_3_project_id' => 'required',
            'menu_item_4_project_id' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
