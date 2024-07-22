<?php

namespace App\Http\Controllers\Resposta;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use App\Models\Resposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class ListarController
{
    use AsAction;

    public function __invoke(Request $request)
    {
        $denuncia = Denuncia::where('protocolo', $request->protocolo)->first();

        if ($denuncia && Hash::check($request->senha, $denuncia->senha)) {

            if (!$denuncia) {
                return response()->json([
                    'error' => 'Denúncia não encontrada'
                ], 404);
            }

            $respostas = Resposta::whereIn('denuncias_id', [$denuncia->id])->get();

            return response()->json([
                'respostas' => $respostas
            ]);
        }
    }

}
