<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseAnswer extends Model
{
    use HasFactory;
    protected $fillable = ['survey_response_id', 'question_option_id', 'question_id'];
    public function questionOption()
    {
        return $this->belongsTo(QuestionOption::class);
    }
    public function unit()
    {
        return $this->belongsTo(Units::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function surveyResponse()
    {
        return $this->belongsTo(SurveyResponse::class);
    }
}
