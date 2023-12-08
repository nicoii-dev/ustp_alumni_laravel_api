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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('college');
            $table->string('college_address');
            $table->string('course');
            $table->string('college_sy');
            $table->string('high_school');
            $table->string('high_address');
            $table->string('high_sy');
            $table->string('elem_school');
            $table->string('elem_address');
            $table->string('elem_sy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
