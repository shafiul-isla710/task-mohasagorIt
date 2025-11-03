<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class AdminUpdateRequest extends ApiFormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->admin->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|boolean|in:0,1',
        ];
    }
}
