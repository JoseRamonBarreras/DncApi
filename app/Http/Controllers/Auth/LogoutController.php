<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LogoutController extends Controller
{
    function logout(Request $request){
        $request->validate([
            'user_id' => ['required']
        ]);

        try {
            $user = User::find($request->user_id);
            $user->tokens()->delete();
            return response()->json(['message' => "Logged out Please come back again!!",'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }        
    }
}
