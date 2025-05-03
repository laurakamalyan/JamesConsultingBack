<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:50',
            'body' => 'required|string|max:500',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Maximum 50 characters',
            'body.required' => 'Body is required',
            'body.max' => 'Maximum 500 characters',
        ];
    }

    /**
     * @param Validator $validator
     * @return string
     */
    public function failedValidation(Validator $validator) : string {
        throw new HttpResponseException(response()->json([
            'message' => $validator->messages()->first(),
        ]));
    }
}
