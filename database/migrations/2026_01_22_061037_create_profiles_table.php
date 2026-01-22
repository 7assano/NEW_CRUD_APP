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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        // الربط مع المستخدم: هذا هو "الخيط" الذي يربط الجدولين
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        $table->string('phone')->nullable(); // حقل لرقم الهاتف
        $table->text('bio')->nullable();    // حقل للسيرة الذاتية
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
