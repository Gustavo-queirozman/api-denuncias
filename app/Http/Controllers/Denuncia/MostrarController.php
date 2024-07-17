<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class MostrarController
{
    use AsAction;
    public function __invoke(Request $request, $protocolo)
    {
        $denuncia = Denuncia::where('protocolo', $protocolo)->first();

        if (!$denuncia) {
            return response()->json([
                'error' => 'Denúncia não encontrada'
            ], 404);
        }

        return response()->json([
            'denuncia' => $denuncia
        ], 200);
    }
}
