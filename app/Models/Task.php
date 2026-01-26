<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'priority',      // 👈 جديد
        'is_favorite',   // 👈 جديد
        'user_id',
        'category_id',
    ];

    // تحويل is_completed و is_favorite إلى boolean
    protected $casts = [
        'is_completed' => 'boolean',
        'is_favorite' => 'boolean',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag');
    }

    // 👇 Scopes للفلترة (اختياري لكن مفيد جداً)

    // فلترة حسب الأولوية
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    // المهام المفضلة فقط
    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    // المهام المكتملة فقط
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    // المهام غير المكتملة فقط
    public function scopePending($query)
    {
        return $query->where('is_completed', false);
    }
}
