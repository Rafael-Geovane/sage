<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        // Check Admin table
        $admin = Admin::where('email', $credentials['email'])->first();
        if ($admin && Hash::check($credentials['senha'], $admin->senha_hash)) {
            return response()->json(['message' => 'Login successful', 'role' => 'admin', 'user' => $admin])
                ->cookie('sage_role', 'admin', 60*24*30, '/')
                ->cookie('sage_email', urlencode($admin->email), 60*24*30, '/');
        }

        // Check Usuario table
        $usuario = Usuario::where('email', $credentials['email'])->first();
        if ($usuario && Hash::check($credentials['senha'], $usuario->senha_hash)) {
            return response()->json(['message' => 'Login successful', 'role' => 'user', 'user' => $usuario])
                ->cookie('sage_role', 'user', 60*24*30, '/')
                ->cookie('sage_email', urlencode($usuario->email), 60*24*30, '/');
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
