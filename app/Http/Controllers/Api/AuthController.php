<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)
                ->where('role', 'pengguna')
                ->first();
            if (!empty($user) && Hash::check($request->password, $user->password)) {
                $token = $user->createToken('token');
                return response()->json([
                    'status' => true,
                    'data' => [
                        'user' => new UserResource($user),
                        'token' => $token->plainTextToken,
                    ],
                    'errors' => null,
                    'message' => 'Pengguna berhasil login!',
                ], 200);
            }
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => 'email atau password salah!',
                'message' => 'Gagal login',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/AuthController.login!'
            ], 500);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->hp,
                'title' => $request->title,
                'role' => 'pengguna',
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'status' => true,
                'data' => new UserResource($user),
                'errors' => null,
                'message' => 'Pengguna berhasil melakukan pendaftaran akun!'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/AuthController.register!'
            ], 500);
        }
    }

    public function profile(Request $request): JsonResponse
    {
        try {
            $data = $request->user();
            return response()->json([
                'status' => true,
                'data' => new UserResource($data),
                'errors' => null,
                'message' => 'Profile pengguna berhasil ditampilkan!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => "Terdapat kesalahan pada Api/AuthController.profile!",
            ], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'data' => null,
                'errors' => null,
                'message' => 'Pengguna berhasil melakukan logout!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/AuthController.register!'
            ], 500);
        }
    }

    public function editProfile(EditProfileRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->hp,
                'alamat' => $request->alamat
            ]);
            $data = new UserResource(User::findOrFail($request->user()->id));
            return response()->json([
                'status' => true,
                'data' => $data,
                'errors' => null,
                'message' => 'Profile pengguna berhasil diubah!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/AuthController.editProfile!',
            ], 500);
        }
    }
}
