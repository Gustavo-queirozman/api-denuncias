<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class ListarController
{
    use AsAction;

    public function __invoke(Request $request)
    {
        try {
            $departamentosId = Auth::user()->departamentos_id;
            $denuncias = Denuncia::where('departamentos_id', '!=', $departamentosId)->get();
            return response()->json([
                "denuncias" => $denuncias
            ]);
        } catch (\Exception $error) {
            return response()->json([
                "error" => $error
            ]);
        }
    }
}
