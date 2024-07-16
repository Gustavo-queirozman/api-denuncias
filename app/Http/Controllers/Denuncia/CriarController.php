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
        $denuncia['numero_protocolo'] = $protocolo;
        $denuncia['users_id'] = Auth::user()->id;

        try {
            $idDenuncia = Denuncia::created($denuncia);
        } catch (\Exception $error) {
        }

        $anexos = $request->file('anexos');
        foreach ($anexos as $anexo) {
            $nomeAnexo = $anexo->getClientOriginalName();
            $extensaoAnexo = $anexo->getClientOriginalExtension();
            $anexo['nome_anexo'] = $this->nomearAnexo() . "." . $extensaoAnexo;
            $anexo['denuncias_id'] = $idDenuncia;

            Storage::put($nomeAnexo, $anexo->getContent());

            try {
                Anexo::insert($anexo);
            } catch (\Exception $error) {
                return response()->json([
                    "error" => $error
                ]);
            }
        }

        return response()->json([
            "message" => "Denuncia criada com sucesso"
        ]);
    }

    private function validaDados($request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'funcao' => 'required|string|max:255',
            'email' => 'email|max:256',
            'telefone' => 'max:15',
            'descricao' => 'required|max:255',
            'status' => 'required|max:50',
            'referencia_protocolo' => 'max:50',
        ]);
    }

    private function geraProtocolo()
    {
        return Carbon::now()->format('YmdHmsv');
    }

    private function nomearAnexo()
    {
        Carbon::now()->format('YmdHmsv');
    }
}
