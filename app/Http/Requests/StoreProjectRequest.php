<?php

namespace App\Http\Requests;

use App\Models\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:1',
                'max:100',
                'required',
                'unique:projects',
            ],
            'ticket_prefix' => [
                'string',
                'min:1',
                'max:5',
                'required',
                'unique:projects'
            ],
            'project_owner_id' => [
                'required',
                'integer',
            ],
            'project_status_id' => [
                'required',
                'integer',
            ],
            'type' => [
                'required',
            ],
            'members.*' => [
                'integer',
            ],
            'members' => [
                'required',
                'array',
            ],
        ];
    }
}
