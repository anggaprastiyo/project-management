<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingNoteUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('meeting_note_user', function (Blueprint $table) {
            $table->unsignedBigInteger('meeting_note_id');
            $table->foreign('meeting_note_id', 'meeting_note_id_fk_10218589')->references('id')->on('meeting_notes')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_10218589')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
