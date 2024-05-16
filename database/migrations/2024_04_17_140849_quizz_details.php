<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_details', function (Blueprint $table) {
            $table->id('QuizDetailID');
            $table->unsignedBigInteger('quizz_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('user_answer')->nullable();

            $table->foreign('quizz_id')->references('quizz_id')->on('quizzes')->onDelete('cascade');
            $table->foreign('question_id')->references('QuestionID')->on('questions')->onDelete('cascade');
            $table->foreign('user_answer')->references('AnswerID')->on('answers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_details');
    }
};
