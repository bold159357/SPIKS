<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class indikasi extends Model
{
    use HasFactory;

    protected $table = 'indikasi';

    protected $fillable = [
        'name',
    ];

    public function kepribadian()
    {
        return $this->belongsToMany(kepribadian::class, 'rule', 'indikasi_id', 'kepribadian_id');
    }
}
