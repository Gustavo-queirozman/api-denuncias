<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class ExcluirController
{
    use AsAction;

    public function __invoke(Request $reques, $id)
    {

            $usuario = User::find($id);
            $usuario->delete();
            return response()->json(["message" => "deletado com sucesso!"], 202);

    }
}
