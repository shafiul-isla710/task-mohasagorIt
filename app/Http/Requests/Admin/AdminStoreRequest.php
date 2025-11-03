<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class AdminStoreRequest extends ApiFormRequest
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
            'email' => 'required|email|unique:users,email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|boolean|in:0,1',
        ];
    }
}
