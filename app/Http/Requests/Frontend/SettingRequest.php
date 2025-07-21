<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'username' => ['required', 'min:3', 'max:50'],
            'email' => ['required', 'email'],
            // 'password' => ['required', 'string', 'min:8', 'max:50'],
            // 'image' => ['required' , 'image' , 'mimes:jpeg,png,jpg,gif,svg' , 'max:2048'],
            'phone' => ['required', 'numeric'],
            'country' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:50'],
            'street' => ['required', 'max:50'],
        ];
    }
}
