<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'project_status_create',
            ],
            [
                'id'    => 18,
                'title' => 'project_status_edit',
            ],
            [
                'id'    => 19,
                'title' => 'project_status_show',
            ],
            [
                'id'    => 20,
                'title' => 'project_status_delete',
            ],
            [
                'id'    => 21,
                'title' => 'project_status_access',
            ],
            [
                'id'    => 22,
                'title' => 'project_create',
            ],
            [
                'id'    => 23,
                'title' => 'project_edit',
            ],
            [
                'id'    => 24,
                'title' => 'project_show',
            ],
            [
                'id'    => 25,
                'title' => 'project_delete',
            ],
            [
                'id'    => 26,
                'title' => 'project_access',
            ],
            [
                'id'    => 27,
                'title' => 'management_access',
            ],
            [
                'id'    => 28,
                'title' => 'referential_access',
            ],
            [
                'id'    => 29,
                'title' => 'ticket_type_create',
            ],
            [
                'id'    => 30,
                'title' => 'ticket_type_edit',
            ],
            [
                'id'    => 31,
                'title' => 'ticket_type_show',
            ],
            [
                'id'    => 32,
                'title' => 'ticket_type_delete',
            ],
            [
                'id'    => 33,
                'title' => 'ticket_type_access',
            ],
            [
                'id'    => 34,
                'title' => 'ticket_priority_create',
            ],
            [
                'id'    => 35,
                'title' => 'ticket_priority_edit',
            ],
            [
                'id'    => 36,
                'title' => 'ticket_priority_show',
            ],
            [
                'id'    => 37,
                'title' => 'ticket_priority_delete',
            ],
            [
                'id'    => 38,
                'title' => 'ticket_priority_access',
            ],
            [
                'id'    => 39,
                'title' => 'ticket_status_create',
            ],
            [
                'id'    => 40,
                'title' => 'ticket_status_edit',
            ],
            [
                'id'    => 41,
                'title' => 'ticket_status_show',
            ],
            [
                'id'    => 42,
                'title' => 'ticket_status_delete',
            ],
            [
                'id'    => 43,
                'title' => 'ticket_status_access',
            ],
            [
                'id'    => 44,
                'title' => 'ticket_create',
            ],
            [
                'id'    => 45,
                'title' => 'ticket_edit',
            ],
            [
                'id'    => 46,
                'title' => 'ticket_show',
            ],
            [
                'id'    => 47,
                'title' => 'ticket_delete',
            ],
            [
                'id'    => 48,
                'title' => 'ticket_access',
            ],
            [
                'id'    => 49,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 50,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 51,
                'title' => 'comment_create',
            ],
            [
                'id'    => 52,
                'title' => 'comment_edit',
            ],
            [
                'id'    => 53,
                'title' => 'comment_show',
            ],
            [
                'id'    => 54,
                'title' => 'comment_delete',
            ],
            [
                'id'    => 55,
                'title' => 'comment_access',
            ],
            [
                'id'    => 56,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
