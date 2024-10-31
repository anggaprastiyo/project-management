<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('project_owner_id')->nullable();
            $table->foreign('project_owner_id', 'project_owner_fk_10217399')->references('id')->on('users');
            $table->unsignedBigInteger('project_status_id')->nullable();
            $table->foreign('project_status_id', 'project_status_fk_10217400')->references('id')->on('project_statuses');
        });
    }
}
