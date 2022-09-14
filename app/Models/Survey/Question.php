<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['body', 'kind'];

    public function survey()
    {
        return $this->belongsTo('App\Models\Survey\Survey', 'survey_id');
    }

    public function responses()
    {
        return $this->hasMany('App\Models\Survey\QuestionResponse');
    }
}
