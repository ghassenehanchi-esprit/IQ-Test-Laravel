<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id('quizz_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('UserID')->on('users')->onDelete('cascade');
            $table->dateTime('quizz_date');
            $table->integer('quizz_score');
            $table->boolean('quizz_status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};
