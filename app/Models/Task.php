<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;  // ← تأكد من وجود HasFactory

    protected $fillable = [
        'title',
        'description',
        'priority',
        'is_completed',
        'is_favorite',
        'image',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'is_favorite' => 'boolean',
    ];

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
        // المهمة تنتمي لعدة وسوم
        return $this->belongsToMany(Tag::class);
    }
}
