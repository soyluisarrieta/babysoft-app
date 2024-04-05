<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;


class AuthenticationController extends Controller
{

  /**
   * Login authentication
   */
  public function login(Request $request): JsonResponse
  {
    $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
      'device_name' => ['required'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['Las credenciales proporcionadas son incorrectas.']
      ]);
    }

    return response()->json([
      'token' => $user->createToken($request->device_name)->plainTextToken
    ]);
  }

  /**
   * Register authentication
   */
  public function register(Request $request): JsonResponse
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Password::defaults()],
      'device_name' => ['required'],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    return response()->json([
      'token' => $user->createToken($request->device_name)->plainTextToken
    ]);
  }
  
  /**
   * Logout authentication
   */
  public function logout(Request $request): Response {
    $request->user()->currentAccessToken()->delete();
    return response()->noContent();
  }
}
