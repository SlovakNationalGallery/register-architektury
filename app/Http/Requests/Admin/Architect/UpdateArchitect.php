<?php

namespace App\Http\Requests\Admin\Architect;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateArchitect extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.architect.edit', $this->architect);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'source_id' => ['sometimes', Rule::unique('architects', 'source_id')->ignore($this->architect->getKey(), $this->architect->getKeyName()), 'integer'],
            'first_name' => ['sometimes', 'string'],
            'last_name' => ['sometimes', 'string'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string'],
            'death_date' => ['nullable', 'date'],
            'death_place' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            
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
