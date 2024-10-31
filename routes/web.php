<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::post('users/sync', 'UsersController@syncUser')->name('users.sync');

    // Project Status
    Route::delete('project-statuses/destroy', 'ProjectStatusController@massDestroy')->name('project-statuses.massDestroy');
    Route::resource('project-statuses', 'ProjectStatusController');

    // Project
    Route::delete('projects/destroy', 'ProjectController@massDestroy')->name('projects.massDestroy');
    Route::post('projects/media', 'ProjectController@storeMedia')->name('projects.storeMedia');
    Route::post('projects/ckmedia', 'ProjectController@storeCKEditorImages')->name('projects.storeCKEditorImages');
    Route::resource('projects', 'ProjectController');

    // Ticket Type
    Route::delete('ticket-types/destroy', 'TicketTypeController@massDestroy')->name('ticket-types.massDestroy');
    Route::resource('ticket-types', 'TicketTypeController');

    // Ticket Priority
    Route::delete('ticket-priorities/destroy', 'TicketPriorityController@massDestroy')->name('ticket-priorities.massDestroy');
    Route::resource('ticket-priorities', 'TicketPriorityController');

    // Ticket Status
    Route::delete('ticket-statuses/destroy', 'TicketStatusController@massDestroy')->name('ticket-statuses.massDestroy');
    Route::resource('ticket-statuses', 'TicketStatusController');

    // Ticket
    Route::delete('tickets/destroy', 'TicketController@massDestroy')->name('tickets.massDestroy');
    Route::post('tickets/media', 'TicketController@storeMedia')->name('tickets.storeMedia');
    Route::post('tickets/ckmedia', 'TicketController@storeCKEditorImages')->name('tickets.storeCKEditorImages');
    Route::resource('tickets', 'TicketController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Comment
    Route::delete('comments/destroy', 'CommentController@massDestroy')->name('comments.massDestroy');
    Route::post('comments/media', 'CommentController@storeMedia')->name('comments.storeMedia');
    Route::post('comments/ckmedia', 'CommentController@storeCKEditorImages')->name('comments.storeCKEditorImages');
    Route::resource('comments', 'CommentController');

    // Meeting Notes
    Route::delete('meeting-notes/destroy', 'MeetingNotesController@massDestroy')->name('meeting-notes.massDestroy');
    Route::post('meeting-notes/media', 'MeetingNotesController@storeMedia')->name('meeting-notes.storeMedia');
    Route::post('meeting-notes/ckmedia', 'MeetingNotesController@storeCKEditorImages')->name('meeting-notes.storeCKEditorImages');
    Route::resource('meeting-notes', 'MeetingNotesController');

    // Board
    Route::delete('boards/destroy', 'BoardController@massDestroy')->name('boards.massDestroy');
    Route::resource('boards', 'BoardController');

    // Road Map
    Route::delete('road-maps/destroy', 'RoadMapController@massDestroy')->name('road-maps.massDestroy');
    Route::resource('road-maps', 'RoadMapController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
