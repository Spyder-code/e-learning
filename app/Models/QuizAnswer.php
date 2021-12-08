<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    // use Uuid;

    protected $fillable = [
        'question_id',
        'quiz_result_id',
        'answer',
        'is_correct'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }

    public function result()
    {
        return $this->belongsTo(QuizResult::class);
    }

}
