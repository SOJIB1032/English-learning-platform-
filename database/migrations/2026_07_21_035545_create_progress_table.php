<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('progress', function (Blueprint $table) {

        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('lesson_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->boolean('lesson_completed')
            ->default(false);

        $table->boolean('quiz_completed')
            ->default(false);

        $table->unsignedInteger('quiz_score')
            ->default(0);

        $table->unsignedInteger('quiz_total')
            ->default(0);

        $table->timestamp('completed_at')
            ->nullable();

        $table->timestamps();

        $table->unique([
            'user_id',
            'lesson_id'
        ]);
    });
}
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};