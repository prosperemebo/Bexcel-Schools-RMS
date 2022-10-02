<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_records', function (Blueprint $table) {
            $table->uuid('id', 10)->primary();
            $table->foreignUuid('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreignUuid('subject_id')->references('id')->on('subject_offers')->onDelete('cascade');
            $table->foreignUuid('session_id')->references('id')->on('academic_sessions')->onDelete('cascade');
            $table->integer('ca_score');
            $table->integer('exam_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_records');
    }
};
