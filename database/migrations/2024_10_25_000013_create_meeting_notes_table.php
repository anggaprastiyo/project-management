<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingNotesTable extends Migration
{
    public function up()
    {
        Schema::create('meeting_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('meeting_date');
            $table->string('topic');
            $table->longText('note');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
