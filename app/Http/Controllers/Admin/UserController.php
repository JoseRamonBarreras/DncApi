<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Interfaces\UploadServiceInterface;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserLogs;
use App\Models\Cliente;
use App\Models\ClienteConfig;
use App\Models\ClienteEnvioConfig;
use App\Models\ClienteHorario;
use App\Models\Status;
use App\Models\Plan;
use DB;

class UserController extends Controller
{
    public function logs()
    {
        return UserLogs::with('user.profile')
            ->latest()
            ->get();
    }

    public function roles()
    {
        return Role::where('name', '<>', 'SISTEMAS')
            ->select('id', 'name as rol')
            ->orderBy('id')
            ->get();
    }

    public function index()
    {
        return User::with(['cliente', 'cliente.plan',
            'cliente.status','profile', 'roles:id,name'])
            ->whereHas('roles', function ($query) {
                $query->where('name', '<>', 'SISTEMAS');
            })
            ->get();
    }

    public function show(User $user)
    {
        return response()->json([
            'id' => $user->id,
            'nombre' => $user->name,
            'correo' => $user->email,
            'phone' => $user->profile->phone ?? ''
        ]);
    }

    public function store(Request $request, UploadServiceInterface $uploadService)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20'
        ]);

        try {
            DB::beginTransaction();

            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'email' => $request->correo,
                'fecha_registro' => now(),
                'fecha_vencimiento' => now()->addDays(7),
                'status_id' => Status::where('nombre', 'activo')->first()->id,
                'plan_id' => Plan::where('nombre', 'basico')->first()->id,
            ]);

            $user = User::create([
                'name' => 'Administrador',
                'email' => $request->correo,
                'password' => Hash::make($request->password),
                'cliente_id' => $cliente->id,
            ]);

            $user->assignRole(2); // ADMINISTRADOR

            Profile::create([
                'phone' => $request->filled('phone') ? $request->phone : '',
                'user_id' => $user->id
            ]);

            ClienteConfig::create([
                'cliente_id' => $cliente->id,
                'whatsapp' => $request->filled('phone') ? $request->phone : null,
                'logo_url' => '',
                'portada_url' => '',
                'direccion' => '',
                'ubicacion_lat' => null,
                'ubicacion_lng' => null,
            ]);

            DB::commit();

            return response()->json([
                'status_code' => 201,
                'message' => 'Cliente y usuario creados exitosamente.',
                'user' => $user->only('id', 'name', 'email'),
                'cliente' => $cliente->only('id', 'nombre', 'email'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, User $usuario, UploadServiceInterface $uploadService)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            $usuario->update([
                'name' => $request->nombre,
                'email' => $request->correo,
            ]);

            $usuario->profile()->updateOrCreate(
                ['user_id' => $usuario->id],
                [
                    'phone' => $request->phone,
                ]
            );

            DB::commit();

            return response()->json($usuario->fresh('profile'));
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'new_password' => 'required|string|min:6'
        ]);

        try {
            $user = User::findOrFail($request->id);
            $user->update(['password' => Hash::make($request->new_password)]);

            return response()->json(['message' => 'Contraseña actualizada']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        // $request->validate(['id' => 'required|exists:users,id']);

        // try {
        //     $user = User::findOrFail($request->id);
        //     $user->delete();

        //     return response()->json(['message' => 'Usuario eliminado']);
        // } catch (Exception $e) {
        //     return response()->json(['message' => $e->getMessage()], 500);
        // }
    }

}
