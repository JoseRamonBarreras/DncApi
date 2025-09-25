<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Encuesta;
use Carbon\Carbon;
use DB;

class EncuestaController extends Controller
{
    public function index($id){
        $cliente = Cliente::with('encuestas.puesto')->select('id', 'nombre')->findOrFail($id);
        return [
            'id' => $cliente->id,
            'nombre' => $cliente->nombre,
            'encuestas' => $cliente->encuestas,
        ];
    }

    public function store(Request $request){
        $encuesta = new Encuesta();
        $encuesta->titulo = $request->Encuesta['titulo'];
        $encuesta->descripcion = $request->Encuesta['descripcion'];
        $encuesta->fecha_creacion = Carbon::now();
        $encuesta->user_id = $request->UserId;
        $encuesta->cliente_id = $request->ClienteId;
        $encuesta->puesto_id = $request->Encuesta['puesto'];
        $encuesta->save();
        return $this->message('success', 'Guardado!', $encuesta);
    }

    public function update(Request $request, $id){
        $encuesta = Encuesta::findOrFail($id);
        $encuesta->titulo = $request->Encuesta['titulo'];
        $encuesta->descripcion = $request->Encuesta['descripcion'];
        $encuesta->puesto_id = $request->Encuesta['puesto'];
        $encuesta->save();
        return $this->message('success', 'Actualizado!', $encuesta);
    }

    public function delete($id){
        $encuesta = Encuesta::findOrFail($id);
        $encuesta->activo = 0;
        $encuesta->save();
        return $this->message('success', 'Encuesta dado de baja!', $encuesta);
    }

    private function message($type, $title, $object ){
        return response()->json(
            [
                "type" => $type,
                "title" => $title,
                "object" => $object
            ]
        );
    }
}
