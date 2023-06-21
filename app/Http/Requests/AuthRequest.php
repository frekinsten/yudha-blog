<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
{
    protected static $NEEDS_AUTHORIZATION = true;
    protected static $ERROR_MESSAGES      = [
        'required'  => ':attribute tidak boleh kosong',
        'string'    => ':attribute harus berupa string',
        'min'       => ':attribute harus minimal :min karakter',
        'email'     => 'ini bukan format :attribute yang benar',
        'unique'    => ':attribute sudah ada',
        'confirmed' => ':attribute tidak sama',
    ];
    protected static $ATTRIBUTE_NAMES     = [
        'name'  => 'Nama',
        'email'      => 'Email',
        'password'     => 'Passsword',
        'password_confirmation' => 'Passsword Konfirmasi',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return self::$NEEDS_AUTHORIZATION;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return static::$ERROR_MESSAGES;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return static::$ATTRIBUTE_NAMES;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (request()->is('auth/login')) {
            $nameRule       = ['nullable'];
            $emailRule      = ['required', 'email', 'min:3'];
            $passwordRule   = ['required', 'string'];
            $confirmPasswordRule   = ['nullable'];
        } else if (request()->is('auth/register')) {
            $nameRule       = ['required', 'string', 'min:3'];
            $emailRule      = ['required', 'email', 'min:3', 'unique:users,email'];
            $passwordRule   = ['required', 'string', 'confirmed', 'min:5'];
            $confirmPasswordRule   = ['required', 'string'];
        }

        return [
            'name'     => $nameRule,
            'email'    => $emailRule,
            'password' => $passwordRule,
            'password_confirmation' => $confirmPasswordRule,
        ];
    }

    /**
     * @overrride
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(
            ['errors' => $validator->errors()->all()],
            Response::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
