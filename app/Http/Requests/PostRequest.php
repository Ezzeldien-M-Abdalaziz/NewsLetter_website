<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title'=> ['required' , 'string' , 'min:3' , 'max:50'],
            'desc'=> ['required' , 'min:10'],
            'category_id'=> ['required' , 'exists:categories,id'],
            'comment_able'=> ['in:on,off'],
            'images'=> ['nullable'],
            'images.*'=> ['image' , 'mimes:jpeg,png,jpg,gif,svg' , 'max:2048'],
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         ''
    //     ];
    // }

    // public function attributes(): array
    // {
    //     return [
    //         'title' => 'Post Title',
    //     ];
    // }
}
