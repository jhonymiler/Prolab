<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundacao extends Model
{
    use HasFactory;

    protected $table = 'fundacoes';

    protected $fillable = [
        'nome',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
