<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('label')->nullable();
            $table->longText('content');
            $table->integer('point')->nullable();
            $table->string('design_link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
