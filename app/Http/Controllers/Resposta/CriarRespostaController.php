<?php

namespace App\Http\Controllers\Resposta;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use App\Models\Resposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class CriarRespostaController
{
    use AsAction;

    public function __invoke(Request $request)
    {
        $idDenuncia = Denuncia::find('protocolo', $request->protocolo)->get('id');
        $this->validaDados($request);
        $resposta['fk_users'] = Auth::user()->id;
        $resposta['fk_denuncias'] = $idDenuncia;
        try{
            Resposta::created($resposta);
        }catch(\Exception $error){

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
