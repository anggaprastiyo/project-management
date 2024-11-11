<aside class="main-sidebar sidebar-light-info" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('project.png') }}" width="50px">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li>
                    <select class="searchable-field form-control">

                    </select>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/audit-logs*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/projects*") ? "menu-open" : "" }} {{ request()->is("admin/tickets*") ? "menu-open" : "" }} {{ request()->is("admin/boards*") ? "menu-open" : "" }} {{ request()->is("admin/road-maps*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/projects*") ? "active" : "" }} {{ request()->is("admin/tickets*") ? "active" : "" }} {{ request()->is("admin/boards*") ? "active" : "" }} {{ request()->is("admin/road-maps*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-minus-square">

                            </i>
                            <p>
                                {{ trans('cruds.management.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('project_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.projects.index") }}" class="nav-link {{ request()->is("admin/projects") || request()->is("admin/projects/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-project-diagram">

                                        </i>
                                        <p>
                                            {{ trans('cruds.project.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ticket_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.tickets.index") }}" class="nav-link {{ request()->is("admin/tickets") || request()->is("admin/tickets/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tasks">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ticket.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('board_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.boards.index") }}" class="nav-link {{ request()->is("admin/boards") || request()->is("admin/boards/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-map">

                                        </i>
                                        <p>
                                            {{ trans('cruds.board.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('road_map_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.road-maps.index") }}" class="nav-link {{ request()->is("admin/road-maps") || request()->is("admin/road-maps/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-calendar-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.roadMap.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('referential_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/project-statuses*") ? "menu-open" : "" }} {{ request()->is("admin/ticket-types*") ? "menu-open" : "" }} {{ request()->is("admin/ticket-priorities*") ? "menu-open" : "" }} {{ request()->is("admin/ticket-statuses*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/project-statuses*") ? "active" : "" }} {{ request()->is("admin/ticket-types*") ? "active" : "" }} {{ request()->is("admin/ticket-priorities*") ? "active" : "" }} {{ request()->is("admin/ticket-statuses*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-minus-square">

                            </i>
                            <p>
                                {{ trans('cruds.referential.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('project_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.project-statuses.index") }}" class="nav-link {{ request()->is("admin/project-statuses") || request()->is("admin/project-statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-tag">

                                        </i>
                                        <p>
                                            {{ trans('cruds.projectStatus.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ticket_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ticket-types.index") }}" class="nav-link {{ request()->is("admin/ticket-types") || request()->is("admin/ticket-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ticketType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ticket_priority_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ticket-priorities.index") }}" class="nav-link {{ request()->is("admin/ticket-priorities") || request()->is("admin/ticket-priorities/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-exclamation-circle">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ticketPriority.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ticket_status_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ticket-statuses.index") }}" class="nav-link {{ request()->is("admin/ticket-statuses") || request()->is("admin/ticket-statuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-clipboard-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.ticketStatus.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('comment_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.comments.index") }}" class="nav-link {{ request()->is("admin/comments") || request()->is("admin/comments/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-comment-dots">

                            </i>
                            <p>
                                {{ trans('cruds.comment.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('meeting_note_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.meeting-notes.index") }}" class="nav-link {{ request()->is("admin/meeting-notes") || request()->is("admin/meeting-notes/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-sticky-note">

                            </i>
                            <p>
                                {{ trans('cruds.meetingNote.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>