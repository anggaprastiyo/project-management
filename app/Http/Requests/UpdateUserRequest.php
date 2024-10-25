<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
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
                'required',
                'unique:users,email,' . request()->route('user')->id,
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
