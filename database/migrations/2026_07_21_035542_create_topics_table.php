<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('description')->nullable();

            $table->unsignedInteger('serial')->default(1);

            $table->timestamps();

            $table->unique(['course_id', 'serial']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};