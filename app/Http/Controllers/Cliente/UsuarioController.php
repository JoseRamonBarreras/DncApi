<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Profile;
use DB;

class UsuarioController extends Controller
{
    public function index($id){
        $cliente = Cliente::with(['usuariosActivos' => function ($q) {
            $q->whereHas('roles', function ($query) {
                $query->where('name', 'JEFE'); 
            })->with('puesto');;
        }])
        ->select('id', 'nombre')
        ->findOrFail($id);
        return [
            'id' => $cliente->id,
            'nombre' => $cliente->nombre,
            'usuarios' => $cliente->usuariosActivos,
        ];
    }

    public function store(Request $request){
        $usuario = new User();
        $usuario->name = $request->Usuario['nombre'];
        $usuario->email = $request->Usuario['correo'];
        $usuario->password = Hash::make($request->Usuario['password']);
        $usuario->cliente_id = $request->ClienteId;
        $usuario->puesto_id = $request->Usuario['puesto'];
        $usuario->save();
        $usuario->assignRole(3); // JEFE

        Profile::create([
            'phone' => '',
            'user_id' => $usuario->id
        ]);

        return $this->message('success', 'Guardado!', $usuario);
    }

    public function update(Request $request, $id){
        $usuario = User::findOrFail($id);
        $usuario->name = $request->Usuario['nombre'];
        $usuario->email = $request->Usuario['correo'];
        $usuario->puesto_id = $request->Usuario['puesto'];
        $usuario->save();
        return $this->message('success', 'Actualizado!', $usuario);
    }

    public function delete($id){
        $usuario = User::findOrFail($id);
        $usuario->activo = 0;
        $usuario->save();
        return $this->message('success', 'Puesto dado de baja!', $usuario);
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
