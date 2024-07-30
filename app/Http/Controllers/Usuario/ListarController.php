<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class ListarController
{
    use AsAction;

    public function __invoke(Request $request)
    {
        if (Gate::allows('permission-adm')) {
        $usuarios = User::all();
        return response()->json([
            "usuarios" => $usuarios
        ],202);
        }else{
            return response()->json(["message" => "Usuário não tem permissão"],403);
        }
    }
}
