<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;
    protected $fillable = ['unit_id', 'service_id', 'usia', 'jenis_kelamin', 'pendidikan', 'pekerjaan', 'masukan'];
    public function unit()
    {
        return $this->belongsTo(Units::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function responseAnswers()
    {
        return $this->hasMany(ResponseAnswer::class);
    }
    public function question()
    {
        return $this->hasMany(Question::class);
    }
    public function questionOption()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
