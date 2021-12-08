<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{

    protected $fillable = [
        'room_id', 'user_id'
    ];

    public $timestamps = false;

    public function room()
    {
        return $this->belongsTo(Room::class,'room_id');
    }
}
