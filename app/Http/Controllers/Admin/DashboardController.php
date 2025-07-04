<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserLogs;
use Spatie\Permission\Models\Role;
use App\Interfaces\UploadServiceInterface;

class DashboardController extends Controller
{
    public function logs()
    {
        return UserLogs::with('user.profile')->orderBy('created_at', 'DESC')->get();
    }

    public function roles()
    {
        return Role::where('id','>',1)->select('id','name as rol')->orderBy('id')->get();
    }

    public function saveRol(Request $request){

        $request->validate([
            'rol' => ['required', 'string', 'max:255']
        ]);
        
        try {
            $role = Role::create(['name' => $request->rol, 'guard_name' => "web"]);
            
            return $role;

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }       
    }

    public function updateRol(Request $request)
    {
        try {
            $rol = Role::where('id',$request->id)
                          ->update(['name' => $request->rol
                        ]);

            return $rol;

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }   
    }

    public function usuarios()
    {
        $rol = request()->header('role');
        $id = request()->header('user_id');

        return User::with(['profile', 'roles' => function($query){ 
            $query->select('id','name as rol'); 
        }])->whereHas('roles', function($query) use ($rol){
            $query->where('name','<>','SISTEMAS');
        })->get();
    }

    public function usuario($id){
        $user = User::find( $id );

        return response()->json([
            'id' => $user->id,
            'nombre' => $user->name,
            'correo' => $user->email,
            'rol' => $user->getRoleNames()[0],
            'favorite_pet' => $user->profile->favorite_pet,
            'phone' => $user->profile->phone,
            'address' => $user->profile->address,
            'privacy_control' => $user->privacy_control
        ]);
    }

    public function registerUsuario(Request $request, UploadServiceInterface $uploadService){

        try {
            $user = User::create([
                'name' => $request->nombre,
                'email' => $request->correo,
                'password' => Hash::make($request->password),
                'plan_id' => 1,
                'privacy_control' => 0
            ]);
            
            $user->assignRole($request->rol);

            $token = $user->createToken('PetQrToken')->plainTextToken;

            $userProfile = Profile::create([
                'favorite_pet' => $request->favorite_pet,
                'phone' => $request->phone,
                'address' => $request->address,
                'user_id' => $user->id
            ]);

            return response()->json([
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'role' => $user->getRoleNames()
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }       
    }

    public function updateUsuario(User $usuario, Request $request, UploadServiceInterface $uploadService)
    {
        try {
            $user = User::find($usuario->id);
            $user->where('id',$usuario->id)
                 ->update([
                    'name' => $request->nombre,
                    'email' => $request->correo
                ]);

            if( !$user->hasAnyRole($request->rol) ) { $user->syncRoles($request->rol); }

            $userProfile = Profile::where('user_id',$usuario->id)
                            ->update([
                                'favorite_pet' => $request->favorite_pet,
                                'phone' => $request->phone,
                                'address' => $request->address
                            ]);
            return $user;

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }   
    }

    public function resetPassword(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->update(['password' => Hash::make($request->new_password)]);
            return $user;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }  
    }

    public function deleteUsuario(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->delete();
            return $user;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }  
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = User::find($request->id);

            $userProfile = Profile::where('user_id',$user->id)
                            ->update([
                                'phone' => $request->phone,
                                'address' => $request->address
                            ]);
            return $user;

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }   
    }

    public function switchControl(Request $request){
        try {
            $user = User::findOrFail($request->userId);
            $user->privacy_control = $request->control;
            $user->saveOrFail();
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
