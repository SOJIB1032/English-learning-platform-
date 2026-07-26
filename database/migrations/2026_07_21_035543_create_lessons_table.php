<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {

            $table->id();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('topic_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('slug');

            $table->unsignedInteger('order')->default(1);

            $table->longText('text_content')->nullable();

            $table->longText('example')->nullable();

            $table->longText('grammar')->nullable();

            $table->json('vocabulary')->nullable();

            $table->longText('summary')->nullable();

            $table->string('audio_url')->nullable();

            $table->string('video_url')->nullable();

            $table->unsignedInteger('duration_minutes')->default(10);

            $table->timestamps();

            $table->unique(['course_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};