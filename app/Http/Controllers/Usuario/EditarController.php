<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class EditarController
{
    use AsAction;

    public function __invoke(Request $request, $id)
    {
        if (Gate::allows('permission-adm')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
                'is_admin' => 'boolean',
                'enable' => 'boolean',
                'departamentos_id' => 'boolean'
            ]);

            // Encontre o usuário pelo ID fornecido
            $usuario = User::find($id);

            // Verifique se o usuário foi encontrado
            if (!$usuario) {
                return response()->json([
                    "error" => "Usuário não encontrado."
                ], 404);
            }

            // Atualize os atributos do usuário com os dados do formulário
            $usuario->name = $request->input('name');
            $usuario->email = $request->input('email');
            $usuario->password = bcrypt($request->input('password'));
            $usuario->is_admin = $request->input('is_admin', false);
            $usuario->enable = $request->input('enable');
            $usuario->departamentos_id = $request->input('departamentos_id');
            $usuario->save();

            return response()->json([
                "message" => "Usuário editado com sucesso!"
            ]);
        } else {
            return response()->json(["message" => "Usuário não tem permissão"], 403);
        }
    }
}
