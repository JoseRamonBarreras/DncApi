<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Puesto;
use DB;

class PuestoController extends Controller
{
    public function puestos($id){
        $cliente = Cliente::with('puestosActivos')->select('id', 'nombre')->findOrFail($id);
        return [
            'id' => $cliente->id,
            'nombre' => $cliente->nombre,
            'puestos' => $cliente->puestosActivos,
        ];
    }

    public function storePuesto(Request $request){
        $puesto = new Puesto();
        $puesto->nombre = $request->Puesto['nombre'];
        $puesto->descripcion = $request->Puesto['descripcion'];
        $puesto->cliente_id = $request->ClienteId;
        $puesto->save();
        return $this->message('success', 'Guardado!', $puesto);
    }

    public function updatePuesto(Request $request, $id){
        $puesto = Puesto::findOrFail($id);
        $puesto->nombre = $request->Puesto['nombre'];
        $puesto->descripcion = $request->Puesto['descripcion'];
        $puesto->save();
        return $this->message('success', 'Actualizado!', $puesto);
    }

    public function deletePuesto($id){
        $puesto = Puesto::findOrFail($id);
        $puesto->activo = 0;
        $puesto->save();
        return $this->message('success', 'Puesto dado de baja!', $puesto);
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
