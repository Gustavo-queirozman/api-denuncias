<?php

namespace App\Http\Controllers\Resposta;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use App\Models\Resposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class CriarRespostaController
{
    use AsAction;

    public function __invoke(Request $request, $protocolo)
    {
        // Busca a denúncia pelo protocolo
        $denuncia = Denuncia::where('protocolo', $protocolo)->first();

        if (!$denuncia) {
            return response()->json([
                "message" => "Denúncia não encontrada"
            ], 404);
        }

        // Valida os dados da requisição
        $this->validaDados($request);

        // Cria a resposta
        $resposta = [
            'users_id' => Auth::user()->id,
            'denuncias_id' => $denuncia->id,
            'resposta' => $request->input('resposta')
        ];

        try {
            Resposta::create($resposta);
        } catch (\Exception $error) {
            // Log do erro para depuração
            Log::error('Erro ao criar resposta: ' . $error->getMessage());

            return response()->json([
                "message" => "Erro ao criar resposta"
            ], 500);
        }

        return response()->json([
            "message" => "Resposta criada com sucesso"
        ]);
    }

    private function validaDados($request)
    {
        $request->validate([
            'resposta' => 'required|string|max:255'
        ]);
    }
}
