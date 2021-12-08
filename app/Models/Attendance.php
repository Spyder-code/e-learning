<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'classroom_id',
        'user_id',
        'date',
        'information'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
