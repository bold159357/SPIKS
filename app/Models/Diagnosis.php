<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnosis';

    protected $fillable = [
        'user_id',
        'kepribadian_id',
        'answer_log'
    ];

    protected $casts = [
        'answer_log' => 'json',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kepribadian()
    {
        return $this->belongsTo(kepribadian::class);
    }

    public function getAnswerLogAttribute($value)
    {
        return json_decode($value);
    }

    public function setAnswerLogAttribute($value)
    {
        $this->attributes['answer_log'] = json_encode($value);
    }
}
