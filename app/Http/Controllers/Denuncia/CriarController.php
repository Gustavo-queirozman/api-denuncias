<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CriarController
{
    use AsAction;

    public function __invoke(Request $request)
    {

        $request->validate([
            'nome' => 'required|string|max:255',
            'funcao' => 'required|string|max:255',
            'email' => 'email|max:256',
            'telefone' => 'max:15',
            'descricao' => 'required|max:255',
            'status' => 'required|max:50',
            'referencia_protocolo' => 'max:50',
            'numero_protocolo' => 'max:50'
        ]);

        
    }
}
