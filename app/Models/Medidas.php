<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medidas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome', 'sigla', 'tipo'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
