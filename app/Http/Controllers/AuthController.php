<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado exitosamente bajo OAuth2.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], Response::HTTP_CREATED);
    }

   
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Las credenciales proporcionadas son incorrectas.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso con Passport.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], Response::HTTP_OK);
    }

    
    public function logout(Request $request): JsonResponse
    {
        // En Passport, se accede al token a través del objeto user() y se revoca de esta forma:
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente y token OAuth2 revocado.'
        ], Response::HTTP_OK);
    }
}