<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTicketsTable extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_10217673')->references('id')->on('projects');
            $table->unsignedBigInteger('reporter_id')->nullable();
            $table->foreign('reporter_id', 'reporter_fk_10218495')->references('id')->on('users');
            $table->unsignedBigInteger('assigne_id')->nullable();
            $table->foreign('assigne_id', 'assigne_fk_10218496')->references('id')->on('users');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_10217678')->references('id')->on('ticket_statuses');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id', 'type_fk_10217679')->references('id')->on('ticket_types');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->foreign('priority_id', 'priority_fk_10217680')->references('id')->on('ticket_priorities');
            $table->unsignedBigInteger('related_ticket_id')->nullable();
            $table->foreign('related_ticket_id', 'related_ticket_fk_10218507')->references('id')->on('tickets');
        });
    }
}
