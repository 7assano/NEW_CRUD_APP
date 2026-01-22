<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // السماح بإضافة هذه الحقول عبر الـ Form
    protected $fillable = ['title', 'description', 'is_completed', 'user_id'];

    // كل مهمة مرتبطة بمستخدم واحد فقط
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}