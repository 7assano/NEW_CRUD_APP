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
    Schema::table('tasks', function (Blueprint $table) {
        // ننشئ عمود user_id ونخبر قاعدة البيانات أنه مرتبط بجدول المستخدمين
        // constrained() تعني أنه يجب أن يكون المستخدم موجوداً
        // cascadeOnDelete() تعني إذا حُذف المستخدم، تُحذف مهامه تلقائياً
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
