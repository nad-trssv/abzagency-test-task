<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone|regex:/^\+380\d{9}$/',
            'position_id' => 'required|exists:positions,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'phone.regex' => 'The phone number must start with +380.',
            'photo.required' => 'The photo field is required.',
            'photo.mimes' => 'The photo must be a jpg or jpeg image.',
            'photo.dimensions' => 'The photo must have dimensions of at least 70x70px.',
            'photo.max' => 'The photo size must not exceed 5MB.',
            'password.required' => 'Поле пароль обязательно для заполнения.',
            'password.confirmed' => 'Пароли не совпадают.',
        ];
    }
}
