<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

    protected $table = 'respostas';

    protected $fillable = [
        'resposta',
        'users_id',
        'denuncias_id'
    ];

    public $timestamp = true;
}
