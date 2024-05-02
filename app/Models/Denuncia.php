<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;

    protected $table = 'denuncias';

    protected $fillable = [
        'nome',
        'funcao',
        'email',
        'telefone',
        'descricao',
        'status',
        'referencia_protocolo',
        'numero_protocolo',
        'users_id',
        'tepos_relato_id',
        'locais_relato_id'
    ];

    public $timestamp = true;

}
