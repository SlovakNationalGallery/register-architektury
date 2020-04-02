<?php

namespace App\Http\Requests\Admin\Building;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreBuilding extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.building.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'source_id' => ['required', Rule::unique('buildings', 'source_id'), 'integer'],
            'title' => ['nullable', 'string'],
            'title_alternatives' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'processed_date' => ['nullable', 'date'],
            'architect_names' => ['nullable', 'string'],
            'builder' => ['nullable', 'string'],
            'builder_authority' => ['nullable', 'string'],
            'location_city' => ['nullable', 'string'],
            'location_district' => ['nullable', 'string'],
            'location_street' => ['nullable', 'string'],
            'location_gps' => ['nullable', 'string'],
            'project_start_dates' => ['nullable', 'string'],
            'project_duration_dates' => ['nullable', 'string'],
            'decade' => ['nullable', 'integer'],
            'style' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'image_filename' => ['nullable', 'string'],
            'bibliography' => ['nullable', 'string'],
            
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
