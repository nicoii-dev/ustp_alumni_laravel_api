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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('post_id')->unsigned()->nullable()->references('id')->on('posts')->onDelete('cascade');
            $table->longText('comment')->nullable();
            $table->boolean('showComment')->nullable()->default(0);
            $table->binary('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
