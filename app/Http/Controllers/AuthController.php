<?php

namespace App\Http\Controllers;

use App\Core\Application\Interfaces\ApiResponseInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request, ApiResponseInterface $apiResponse): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(
                $apiResponse::create(false, 'user logged in', (object) [])
            );
        }

        return response()->json(
            $apiResponse::create(true, 'Not authenticated', (object) []),
            401);
    }
}
