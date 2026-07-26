<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('practices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lesson_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('serial')->default(1);

            $table->longText('question');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practices');
    }
};