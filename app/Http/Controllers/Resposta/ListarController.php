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

    public function __invoke(Request $request)
    {
        $idDenuncia = Denuncia::where('protocolo', $request->protocolo)->pluck('id');
        $respostas = Resposta::whereIn('denuncias_id', $idDenuncia)->get();
        return response()->json([
            'respostas' => $respostas
        ]);
    }
}
