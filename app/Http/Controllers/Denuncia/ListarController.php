<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ListarController
{
    use AsAction;

    public function __invoke(Request $request)
    {
        try {
            $denuncias = Denuncia::all();
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
