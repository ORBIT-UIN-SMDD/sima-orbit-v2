<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string|min:6'
        ], [
            'login.required' => 'Email atau NIM tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        $validation = array_fill_keys(array_keys($request->all()), []);
        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $key => $errors) {
                $validation[$key] = $errors;
            }
            return response()->json([
                'response' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => 'Validation error occurred',
                'validation' => $validation,
                'data' => null
            ], Response::HTTP_BAD_REQUEST);
        }

        // Determine login type (email or nim)
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        $user = User::where($loginType, $request->input('login'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'response' => Response::HTTP_UNAUTHORIZED,
                'success' => false,
                'message' => 'Email/NIM atau password salah',
                'data' => null
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Revoke old tokens (optional - for single device login)
        // $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->load('roles', 'permissions', 'department');

        return response()->json([
            'response' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => new ProfileResource($user),
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'response' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Logout berhasil',
            'data' => null
        ], Response::HTTP_OK);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $user->load('roles', 'permissions', 'department');

        return response()->json([
            'response' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Data user berhasil diambil',
            'data' => new ProfileResource($user)
        ], Response::HTTP_OK);
    }
}
