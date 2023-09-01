<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kepribadian extends Model
{
    use HasFactory;

    protected $table = 'kepribadian';

    protected $fillable = [
        'name',
        'reason',
        'solution',
    ];

    public function indikasi()
    {
        return $this->belongsToMany(indikasi::class, 'rule', 'kepribadian_id', 'indikasi_id');
    }

    public function rule()
    {
        return $this->hasMany(Rule::class);
    }

    public function diagnosa()
    {
        return $this->hasMany(Diagnosa::class);
    }
}
