<?php

namespace App\Http\Controllers\Resposta;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use App\Models\Resposta;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ListarController
{
    use AsAction;

    public function __invoke(Request $request, $protocolo)
    {
        $idDenuncia = Denuncia::where('protocolo', $protocolo)->first();
        $respostas = Resposta::where('denuncias_id', $idDenuncia);
        return response()->json([
            'respostas' => $respostas
        ]);
    }
}
