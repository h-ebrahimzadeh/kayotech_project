<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
    {

        $user = User::where('email', $request->input('email'))->first();


        if ($user->suspend) {
            return response()->json(['suspend' => 'The user is suspend']);

        } else {
            $request->authenticate();
            $request->session()->regenerate();
            $token = $user->createToken('myapptoken')->plainTextToken;
            return response()->json([
                'msg' => 'login successfully.',
                'token' => $token,
            ]);

//        return response()->noContent();
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public
    function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
