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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('OrderId');
            $table->unsignedBigInteger('quizz_id');
            $table->string('payment_method');
            $table->boolean('is_paid');
            $table->string('certif');
            $table->foreign('quizz_id')->references('quizz_id')->on('quizzes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
