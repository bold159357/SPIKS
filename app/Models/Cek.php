<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cek extends Model
{
    use HasFactory;

    protected $table = 'cek';

    protected $fillable = [
        'kepribadian_id',
        'indikasi_id',
    ];

    public function kepribadian()
    {
        return $this->belongsTo(kepribadian::class, 'kepribadian_id');
    }

    public function indikasi()
    {
        return $this->belongsTo(indikasi::class, 'indikasi_id');
    }
}
