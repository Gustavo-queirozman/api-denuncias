<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Models\Anexo;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class MostrarController
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

            $anexos = Anexo::where('denuncias_id', $denuncia->id)->get();

            return response()->json([
                'denuncia' => $denuncia,
                'anexos' => $anexos
            ], 200);
        } else {
            return response()->json(["message" => "Protocolo ou senha incorreta!"],202);
        }
    }
}
