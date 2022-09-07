<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
    protected $fillable = ['caller_number', 'transcription',
                           'recording_url', 'agent_id'];
}
