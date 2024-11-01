<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'uuid' => [
                'string',
                'min:1',
                'max:32',
                'nullable',
            ],
            'nik' => [
                'string',
                'min:1',
                'max:50',
                'nullable',
            ],
            'name' => [
                'string',
                'required',
            ],
            'unit_code' => [
                'string',
                'nullable',
            ],
            'unit_name' => [
                'string',
                'nullable',
            ],
            'job_position_code' => [
                'string',
                'min:1',
                'max:50',
                'nullable',
            ],
            'job_position_text' => [
                'string',
                'nullable',
            ],
            'email' => [
                'nullable',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ];
    }
}
