<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ListarController extends Controller
{
    use AsAction;

    public function __invoke(Request $request)
    {
        $usuarios = User::all();
        return response()->json([
            "usuarios" => $usuarios
        ],202);
    }
}
