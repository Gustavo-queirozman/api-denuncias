<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ExcluirController
{
    use AsAction;

    public function __invoke(Request $request, $id)
    {
        try{
            $denuncia = Denuncia::find($id);
            $denuncia->delete($denuncia);
            return response()->json([
                "message" => "Denuncia excluida com sucesso!"
            ], 202);
        }catch(\Exception $error){
            return response()->json([
                "error" => $error
            ]);
        }
    }
}
