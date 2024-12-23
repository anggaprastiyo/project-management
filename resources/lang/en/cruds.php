<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'uuid'              => 'uuid',
            'uuid_helper'       => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
            'uuid'               => 'uuid',
            'uuid_helper'        => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'uuid'                     => 'uuid',
            'uuid_helper'              => ' ',
            'nik'                      => 'NIK',
            'nik_helper'               => ' ',
            'job_position_code'        => 'Job Position Code',
            'job_position_code_helper' => ' ',
            'job_position_text'        => 'Job Position',
            'job_position_text_helper' => ' ',
            'unit_code'                => 'Unit Code',
            'unit_code_helper'         => ' ',
            'unit_name'                => 'Unit Name',
            'unit_name_helper'         => ' ',
        ],
    ],
    'projectStatus' => [
        'title'          => 'Project Status',
        'title_singular' => 'Project Status',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'uuid'              => 'uuid',
            'uuid_helper'       => ' ',
            'name'              => 'Status Name',
            'name_helper'       => ' ',
            'color'             => 'Status Color',
            'color_helper'      => ' ',
            'is_default'        => 'Default Status',
            'is_default_helper' => 'If checked, this status will be automatically affected to new projects',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'project' => [
        'title'          => 'Project',
        'title_singular' => 'Project',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => ' ',
            'uuid'                  => 'uuid',
            'uuid_helper'           => ' ',
            'cover_image'           => 'Cover Image',
            'cover_image_helper'    => ' ',
            'name'                  => 'Project Name',
            'name_helper'           => ' ',
            'ticket_prefix'         => 'Ticket Prefix',
            'ticket_prefix_helper'  => ' ',
            'project_owner'         => 'Project Owner',
            'project_owner_helper'  => ' ',
            'project_status'        => 'Project Status',
            'project_status_helper' => ' ',
            'description'           => 'Project Description',
            'description_helper'    => ' ',
            'type'                  => 'Project Type',
            'type_helper'           => 'Achieve your project goals with a board, backlog, and roadmap.',
            'created_at'            => 'Created at',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => ' ',
            'status_type'           => 'Status Configuration',
            'status_type_helper'    => 'If custom type selected, you need to configure project specific statuses',
            'member'                => 'Member',
            'member_helper'         => ' ',
            'team'                  => 'Team',
            'team_helper'           => ' ',
        ],
    ],
    'management' => [
        'title'          => 'Management',
        'title_singular' => 'Management',
    ],
    'referential' => [
        'title'          => 'Referential',
        'title_singular' => 'Referential',
    ],
    'ticketType' => [
        'title'          => 'Ticket Type',
        'title_singular' => 'Ticket Type',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'uuid'              => 'uuid',
            'uuid_helper'       => ' ',
            'name'              => 'Type Name',
            'name_helper'       => ' ',
            'color'             => 'Type Color',
            'color_helper'      => ' ',
            'icon'              => 'Type Icon',
            'icon_helper'       => ' ',
            'is_default'        => 'Default Type',
            'is_default_helper' => 'If checked, this type will be automatically affected to new tickets',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'ticketPriority' => [
        'title'          => 'Ticket Priority',
        'title_singular' => 'Ticket Priority',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'uuid'              => 'uuid',
            'uuid_helper'       => ' ',
            'name'              => 'Priority Name',
            'name_helper'       => ' ',
            'color'             => 'Priority Color',
            'color_helper'      => ' ',
            'is_default'        => 'Default Priority',
            'is_default_helper' => 'If checked, this priority will be automatically affected to new tickets',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'ticketStatus' => [
        'title'          => 'Ticket Status',
        'title_singular' => 'Ticket Status',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'uuid'              => 'uuid',
            'uuid_helper'       => ' ',
            'name'              => 'Status Name',
            'name_helper'       => ' ',
            'color'             => 'Status Color',
            'color_helper'      => ' ',
            'order'             => 'Status Order',
            'order_helper'      => ' ',
            'is_default'        => 'Default Status',
            'is_default_helper' => 'If checked, this status will be automatically affected to new ticket status',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'project'           => 'Project',
            'project_helper'    => ' ',
        ],
    ],
    'ticket' => [
        'title'          => 'Ticket',
        'title_singular' => 'Ticket',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => ' ',
            'uuid'                  => 'uuid',
            'uuid_helper'           => ' ',
            'project'               => 'Project',
            'project_helper'        => ' ',
            'code'                  => 'Ticket Code',
            'code_helper'           => ' ',
            'name'                  => 'Ticket Name',
            'name_helper'           => ' ',
            'status'                => 'Ticket Status',
            'status_helper'         => ' ',
            'type'                  => 'Ticket Type',
            'type_helper'           => ' ',
            'priority'              => 'Ticket Priority',
            'priority_helper'       => ' ',
            'content'               => 'Ticket Content',
            'content_helper'        => ' ',
            'point'                 => 'Point',
            'point_helper'          => ' ',
            'created_at'            => 'Created at',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => ' ',
            'attachment'            => 'Attachment',
            'attachment_helper'     => ' ',
            'reporter'              => 'Reporter',
            'reporter_helper'       => ' ',
            'assigne'               => 'Assigne',
            'assigne_helper'        => ' ',
            'label'                 => 'Label',
            'label_helper'          => ' ',
            'design_link'           => 'Design Link',
            'design_link_helper'    => ' ',
            'related_ticket'        => 'Related Ticket',
            'related_ticket_helper' => ' ',
        ],
    ],
    'auditLog' => [
        'title'          => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'description'         => 'Description',
            'description_helper'  => ' ',
            'subject_id'          => 'Subject ID',
            'subject_id_helper'   => ' ',
            'subject_type'        => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id'             => 'User ID',
            'user_id_helper'      => ' ',
            'properties'          => 'Properties',
            'properties_helper'   => ' ',
            'host'                => 'Host',
            'host_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
        ],
    ],
    'comment' => [
        'title'          => 'Comment',
        'title_singular' => 'Comment',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'ticket'            => 'Ticket',
            'ticket_helper'     => ' ',
            'user'              => 'User',
            'user_helper'       => ' ',
            'text'              => 'Text',
            'text_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'uuid'              => 'uuid',
            'uuid_helper'       => ' ',
        ],
    ],
    'meetingNote' => [
        'title'          => 'Meeting Notes',
        'title_singular' => 'Meeting Note',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'project'             => 'Project',
            'project_helper'      => ' ',
            'meeting_date'        => 'Meeting Date',
            'meeting_date_helper' => ' ',
            'participant'         => 'Participant',
            'participant_helper'  => ' ',
            'topic'               => 'Topic',
            'topic_helper'        => ' ',
            'note'                => 'Note',
            'note_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
        ],
    ],
    'board' => [
        'title'          => 'Board',
        'title_singular' => 'Board',
    ],
    'roadMap' => [
        'title'          => 'Road Map',
        'title_singular' => 'Road Map',
    ],

];
