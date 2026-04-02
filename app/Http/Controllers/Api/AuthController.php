<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants sont incorrects.'],
            ]);
        }

        // Ensure user is a Huissier or has access
        if (!$user->isHuissier() && !$user->isSuperAdmin()) {
             return response()->json(['message' => 'Accès non autorisé via mobile.'], 403);
        }

        return response()->json([
            'token' => $user->createToken('mobile-app')->plainTextToken,
            'user' => $user->load('huissier'),
        ]);
    }
}
