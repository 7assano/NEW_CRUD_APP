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
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // عنوان المهمة
        $table->text('description')->nullable(); // وصف المهمة (nullable تعني يمكن تركه فارغاً)
        $table->boolean('is_completed')->default(false); // حالة المهمة (افتراضياً غير منتهية)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
