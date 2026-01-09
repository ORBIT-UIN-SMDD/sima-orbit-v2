<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Get authenticated user profile
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $user->photo_url = $user->getPhoto();
        $user->load('roles', 'permissions');

        return response()->json([
            'success' => true,
            'message' => 'Data profile berhasil diambil',
            'data' => $user
        ], 200);
    }

    /**
     * Update authenticated user profile
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'nim' => 'sometimes|required|string|unique:users,nim,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'job' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'bio' => 'nullable|string',
            'blood_type' => 'nullable|in:A+,B+,AB+,O+,A-,B-,AB-,O-',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.unique' => 'NIM sudah digunakan',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only([
            'name', 'email', 'nim', 'phone', 'place_of_birth',
            'date_of_birth', 'gender', 'job', 'address',
            'latitude', 'longitude', 'bio', 'blood_type'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $photo = $request->file('photo');
            $photoPath = $photo->store('users', 'public');
            $data['photo'] = $photoPath;
        }

        $user->update($data);
        $user->photo_url = $user->getPhoto();

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate',
            'data' => $user
        ], 200);
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini tidak boleh kosong',
            'password.required' => 'Password baru tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah'
            ], 401);
        }

        $user->update([
            'password' => $request->password
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diupdate'
        ], 200);
    }
}
