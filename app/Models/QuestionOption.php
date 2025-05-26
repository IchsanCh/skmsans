<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'question_id', 'bobot'];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
