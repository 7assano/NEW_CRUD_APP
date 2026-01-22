<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function tasks()
    {
        // الوسم ينتمي لعدة مهام
        return $this->belongsToMany(Task::class);
    }
}
