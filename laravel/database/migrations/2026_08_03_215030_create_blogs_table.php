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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('category', 100);
            $table->string('category_slug', 100);
            $table->string('date', 50);
            $table->string('author', 100);
            $table->string('author_role', 100);
            $table->string('author_avatar', 255);
            $table->string('read_time', 50);
            $table->string('image', 255);
            $table->text('excerpt');
            $table->text('content');
            $table->string('status', 20)->default('Published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
