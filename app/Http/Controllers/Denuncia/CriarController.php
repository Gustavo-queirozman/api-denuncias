<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        try{
            Denuncia::created($denuncia);
            return response()->json([
                "message" => "Denuncia criada com sucesso"
            ]);
        }catch(\Exception $error){

        }

    }

    private function validaDados($request){
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

    private function geraProtocolo(){
        return Carbon::now()->format('YmdHmsv');
    }
}
