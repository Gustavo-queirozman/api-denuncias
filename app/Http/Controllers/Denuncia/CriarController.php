<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Models\Anexo;
use App\Models\Denuncia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class CriarController
{
    use AsAction;
    public function __invoke(Request $request)
    {
        $this->validaDados($request);
        $protocolo = $this->geraProtocolo();
        $denuncia = $request->all();

        try {
            $denuncia['protocolo'] = $protocolo;
            $idDenuncia = Denuncia::create($denuncia)->id;
        } catch (\Exception $error) {
            return response()->json([
                "error" => "Erro ao criar a denúncia: " . $error->getMessage()
            ], 500);
        }

        if ($request->hasFile('anexos')) {
            $anexos = $request->file('anexos');

            // Garante que 'anexos' é sempre um array
            if (!is_array($anexos)) {
                $anexos = [$anexos];
            }

            for ($i = 0; $i < count($anexos); $i++) {
                
                if ($anexos[$i]->isValid()) {
                    $extensaoAnexo = $anexos[$i]->getClientOriginalExtension();
                    $nomeAnexo = $this->nomearAnexo() . '.' . $extensaoAnexo;

                    // Salvar o anexo no sistema de arquivos
                    try {
                        $anexos[$i]->storeAs('anexos', $nomeAnexo, 'public');

                        $anexoData = [
                            'nome_anexo' => $nomeAnexo,
                            'denuncias_id' => $idDenuncia
                        ];

                        Anexo::create($anexoData);
                    } catch (\Exception $error) {
                        return response()->json([
                            "error" => "Erro ao salvar o anexo: " . $error->getMessage()
                        ], 500);
                    }
                }

            }
        }

        return response()->json([
            "message" => "Denúncia criada com sucesso",
            "data" => ["protocolo" => $protocolo, "senha" => $request->senha]
        ]);
    }

    private function validaDados(Request $request)
    {
        $request->validate([
            'denuncia' => 'required|string|max:1000',
            'status' => 'required|string|max:20',
            'senha' => 'required|string|max:20',
            'departamentos_id' => 'integer',
            'anexos.*' => 'file|mimes:jpg,jpeg,png,pdf,docx|max:2048' // Validar cada anexo individualmente
        ]);
    }

    private function geraProtocolo()
    {
        return now()->format('YmdHmsv');
    }

    private function nomearAnexo()
    {
        return now()->format('YmdHmsv');
    }
}
