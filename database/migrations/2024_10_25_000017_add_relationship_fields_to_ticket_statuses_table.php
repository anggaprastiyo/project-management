<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTicketStatusesTable extends Migration
{
    public function up()
    {
        Schema::table('ticket_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_10217897')->references('id')->on('projects');
        });
    }
}
