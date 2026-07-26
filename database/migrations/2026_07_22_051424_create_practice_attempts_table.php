<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('practice_attempts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('practice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->longText('answer')->nullable();

            $table->timestamp('submitted_at')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'practice_id'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practice_attempts');
    }
};