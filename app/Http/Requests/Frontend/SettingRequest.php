<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            // 'username' => ['required', 'min:3', 'max:50' , 'unique:users,username,'.$this->user()->id], // that chaining way
            'username' => ['required', 'min:3', 'max:50' , Rule::unique('users' , 'username')->ignore($this->user()->id)], //cleaner way
            'email' => ['required', 'email' , Rule::unique('users' , 'email')->ignore($this->user()->id)],
            'phone' => ['required', 'numeric' , Rule::unique('users' , 'phone')->ignore($this->user()->id)],
            'country' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:50'],
            'street' => ['required', 'max:50'],
            'image' => ['nullable' , 'image' , 'mimes:jpeg,png,jpg,gif,svg' , 'max:2048'],
            // 'password' => ['required', 'string', 'min:8', 'max:50'],
        ];
    }
}
