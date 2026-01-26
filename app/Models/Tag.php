<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 👈 تأكد من هذا السطر
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory; // 👈 تأكد من هذا السطر

    protected $fillable = ['name'];

    // العلاقة: الوسم ينتمي للعديد من المهام
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_tag');
    }
}
