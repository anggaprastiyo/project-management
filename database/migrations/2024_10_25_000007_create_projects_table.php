<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('name')->unique();
            $table->string('ticket_prefix');
            $table->longText('description')->nullable();
            $table->string('type');
            $table->string('status_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
