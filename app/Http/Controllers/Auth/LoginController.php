<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use App\Events\UserLogsEvent;
use App\Models\User;
use App\Models\Profile;

class LoginController extends Controller
{
    function login(Request $request){
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        try{
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('PetQrToken')->plainTextToken;
            
        event(new UserLogsEvent($user));

        return response()->json([
            'status_code' => 200,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'role' => $user->getRoleNames(),
            'permissions' => $user->getPermissionsViaRoles(),
            'profile' => $user->profile
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }       

    }
}
