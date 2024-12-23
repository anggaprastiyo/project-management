<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketPrioritiesTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_priorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('name');
            $table->string('color');
            $table->boolean('is_default')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
