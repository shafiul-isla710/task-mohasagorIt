<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class SubSubCategoryUpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:sub_sub_categories,name,'.$this->subsubCategory->id,
            'category_id' => 'sometimes|exists:categories,id',
            'sub_category_id' => 'sometimes|exists:sub_categories,id',
            'status' => 'nullable|boolean|in:0,1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_key' => 'nullable|string|max:255',
            'meta_content' => 'nullable|string|max:255',
        ];
    }
}
