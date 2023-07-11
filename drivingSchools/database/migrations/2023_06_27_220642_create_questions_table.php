<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('test_id');
            // $table->foreign('test_id')->references('id')->on('tests');
            $table->string('question');
            $table->enum('answer',['choice1','choice2','choice3']);
            $table->integer('mark');
            $table->string('choice1');
            $table->string('choice2');
            $table->string('choice3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
