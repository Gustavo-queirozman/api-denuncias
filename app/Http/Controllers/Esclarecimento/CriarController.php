<?php

namespace App\Http\Controllers\Esclarecimento;

use App\Http\Controllers\Controller;
use App\Models\Esclarecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class CriarController
{
    use AsAction;

    public function __invoke(Request $request)
    {
        $validaDados = $request->validate([
            'esclarecimento' => 'required|max:255',
            'denuncias_id' => 'required'
        ]);

        $esclarecimento = $request->all();
        $esclarecimento['users_id'] = Auth::user()->id;
        try{
            Esclarecimento::insert($esclarecimento);
            return response()->json([
                "message" => "Esclarecimento cadastrado com sucesso!"
            ]);
        }catch(\Exception $error){
            return response()->json([
                "error" => $error
            ]);
        }
    }
}
