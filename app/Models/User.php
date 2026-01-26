<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',  // 👈 جديد
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // العلاقات
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // 👇 دالة مساعدة للحصول على رابط الصورة الكامل
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // صورة افتراضية إذا لم يكن هناك صورة
        return asset('images/default-avatar.png');
    }
}
