<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            "title" => ["required", "max:40"],
            "content" => ["required"],
            "slug" => ["required", Rule::unique('posts')->ignore($this->post)],
            "image" => ["required", "max:2048", "mimes:png,jpeg,jpg"],
            "tags" => ["required"],
        ];
    }
}
