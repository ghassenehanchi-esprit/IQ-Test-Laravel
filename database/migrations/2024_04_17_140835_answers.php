<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id('AnswerID');
            $table->unsignedBigInteger('question_id');
            $table->text('answer_text');
            $table->string('answer_image')->nullable();
            $table->boolean('is_correct');
            $table->foreign('question_id')->references('QuestionID')->on('questions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
