<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    protected static $NEEDS_AUTHORIZATION = true;
    protected static $ERROR_MESSAGES      = [
        'required'  => ':attribute tidak boleh kosong',
        'string'    => ':attribute harus berupa string',
        'min'       => ':attribute harus minimal :min karakter',
        'unique'    => ':attribute sudah ada',
        'max'       => ':attribute harus maksimal :max MB',
        'mimes'     => ':attribute harus berekstensi .jpg, .jpeg, .png, .webp',
    ];
    protected static $ATTRIBUTE_NAMES     = [
        'title'         => 'Judul',
        'category_id'   => 'Kategori',
        'img_cover'     => 'Sampul',
        'description'   => 'Deskripsi',
        'tag_ids'       => 'Tags',
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
        return [
            'title'         => ['required', 'string', 'min:3'],
            'slug'          => ['sometimes', 'string', Rule::unique('posts', 'slug')->ignore(request()->id)],
            'category_id'   => ['required', 'string'],
            'tag_ids'       => ['required', 'array', 'min:1'],
            'description'   => ['required', 'string'],
            'img_cover'     => ['sometimes', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
