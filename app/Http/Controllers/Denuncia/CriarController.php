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

        $anexos = $request->file('anexos');

        if (is_array($anexos)) {
            foreach ($anexos as $anexo) {
                $nomeAnexo = $anexo->getClientOriginalName();
                $extensaoAnexo = $anexo->getClientOriginalExtension();
                $anexoData = [
                    'nome_anexo' => $this->nomearAnexo() . "." . $extensaoAnexo,
                    'denuncias_id' => $idDenuncia
                ];

                Storage::put($nomeAnexo, $anexo->getContent());

                try {
                    Anexo::create($anexoData);
                } catch (\Exception $error) {
                    return response()->json([
                        "error" => "Erro ao salvar o anexo: " . $error->getMessage()
                    ], 500);
                }
            }
        }

        return response()->json([
            "message" => "Denúncia criada com sucesso",
            "data" => ["protocolo" => $protocolo, "senha" => $request->senha]
        ]);
    }

    private function validaDados($request)
    {
        $request->validate([
            'denuncia' => 'required|string|max:1000',
            'status' => 'required|string|max:20',
            'senha' => 'required|string|max:20',
            'departamentos_id' => 'integer'
        ]);
    }

    private function geraProtocolo()
    {
        return Carbon::now()->format('YmdHmsv');
    }

    private function nomearAnexo()
    {
        return Carbon::now()->format('YmdHmsv');
    }
}
