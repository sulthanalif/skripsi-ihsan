<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SwitchUserController extends Controller
{
    public function getUsers(): JsonResponse
    {
        try {
            $users = User::whereNot('id', Auth::id())->get();
            return response()->json([
                'status'  => true,
                'data'    => $users,
                'message' => 'Data berhasil diambil.',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'data'    => null,
                'message' => 'Gagal mengambil data: ' . $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function switch(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);

        Auth::login($user);

        return response()->json([
            'status'  => true,
            'data'    => null,
            'message' => 'User berhasil diubah.',
        ], JsonResponse::HTTP_OK);
    }
}
