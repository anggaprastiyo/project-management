<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTypesTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('name');
            $table->string('color');
            $table->string('icon');
            $table->boolean('is_default')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
