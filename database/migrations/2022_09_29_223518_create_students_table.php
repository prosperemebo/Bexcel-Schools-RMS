<?php

use App\Models\Grade;
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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id', 10)->primary();
            $table->foreignUuid('grade_id')->nullable()->references('id')->on('grades')->nullOnDelete();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('admission_number');
            $table->boolean('status')->default(true);
            $table->date('date_of_birth');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name');
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
        Schema::dropIfExists('students');
    }
};
