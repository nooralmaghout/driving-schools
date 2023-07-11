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
        Schema::create('international_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('international_office_id');
            $table->foreign('international_office_id')->references('id')->on('international_offices');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->date('date_of_granting');
            $table->date('date_of_expiring');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_licenses');
    }
};
