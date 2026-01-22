<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    // هذه المصفوفة هي التي تحل المشكلة: نخبر لارافيل أن هذه الحقول مسموح تعبئتها جماعياً
    protected $fillable = [
        'user_id', 
        'phone', 
        'bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}