<?php

namespace App\Models;

use App\Models\QuestionOption;
use App\Models\ResponseAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'pertanyaan',
        'unsur_pelayanan'
    ];

    public function questionOptions()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function responseAnswers()
    {
        return $this->hasMany(ResponseAnswer::class);
    }
    public function getPertanyaanAttribute($value)
    {
        return $value;
    }
}
