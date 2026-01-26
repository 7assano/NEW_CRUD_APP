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
        Schema::create('task_tag', function (Blueprint $table) {
            $table->id();

            // المفتاح الأجنبي للمهمة
            $table->foreignId('task_id')
                ->constrained('tasks')
                ->onDelete('cascade');

            // المفتاح الأجنب�� للوسم
            $table->foreignId('tag_id')
                ->constrained('tags')
                ->onDelete('cascade');

            $table->timestamps();

            // منع التكرار (نفس المهمة مع نفس الوسم)
            $table->unique(['task_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_tag');
    }
};
