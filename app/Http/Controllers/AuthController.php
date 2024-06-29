<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate request
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to authenticate the user
        if (auth()->attempt($credentials)) {
            // Authentication successful
            $user = auth()->user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        // Authentication failed
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}