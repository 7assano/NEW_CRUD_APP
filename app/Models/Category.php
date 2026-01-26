<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 👈 تأكد
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; // 👈 تأكد

    protected $fillable = ['name', 'user_id'];

    // العلاقة: التصنيف ينتمي لمستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة: التصنيف يحتوي على مهام كثيرة
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
