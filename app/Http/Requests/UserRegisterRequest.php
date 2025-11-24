<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'firstname' => ['required','string', 'max:50'],
            'lastname'=> ['required', 'string', 'max:50'],
            'firstnamekana'=> ['required', 'string', 'regex:/\A[ァ-ヴー]+\z/u', 'max:50'],
            'lastnamekana'=> ['required', 'string', 'regex:/\A[ァ-ヴー]+\z/u', 'max:50'],
            'email'=> ['required', 'email', 'unique:users', 'exists:temp_users,email'],
            'phone'=> ['required', 'string', 'regex:/^[0-9-]+$/'],
            'gender'=> ['nullable', 'between:0,2'],
            'password'=> ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
