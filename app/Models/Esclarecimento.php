<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esclarecimento extends Model
{
    use HasFactory;

    protected $table = 'esclarecimentos';

    protected $fillable = [
        'esclarecimento',
        'denuncias_id',
        'users_id'
    ];
}
