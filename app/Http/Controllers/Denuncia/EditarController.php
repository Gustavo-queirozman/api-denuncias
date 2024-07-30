<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class EditarController
{
    use AsAction;

    public function __invoke(Request $request, $id)
    {
        $denuncia = Denuncia::find($id);
        $denuncia->status_id = $request->input('status_id');
        $denuncia->user_status = $request->input('user_status');
        $denuncia->save();

        return response()->json(['message' => 'Editado com sucesso!']);
    }
}
