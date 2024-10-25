<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::apiResource('users', 'UsersApiController');

    // Project Status
    Route::apiResource('project-statuses', 'ProjectStatusApiController');

    // Project
    Route::post('projects/media', 'ProjectApiController@storeMedia')->name('projects.storeMedia');
    Route::apiResource('projects', 'ProjectApiController');

    // Ticket Type
    Route::apiResource('ticket-types', 'TicketTypeApiController');

    // Ticket Priority
    Route::apiResource('ticket-priorities', 'TicketPriorityApiController');

    // Ticket Status
    Route::apiResource('ticket-statuses', 'TicketStatusApiController');

    // Ticket
    Route::post('tickets/media', 'TicketApiController@storeMedia')->name('tickets.storeMedia');
    Route::apiResource('tickets', 'TicketApiController');

    // Comment
    Route::post('comments/media', 'CommentApiController@storeMedia')->name('comments.storeMedia');
    Route::apiResource('comments', 'CommentApiController');
});
