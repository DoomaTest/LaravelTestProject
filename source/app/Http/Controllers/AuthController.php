<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register api
     */
    public function register(Request $request): Response
    {
        $validated = $this->validate($request, [
            'name'                  => 'required|min:4|unique:users,name',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        $success = [
            'token' => $user->createToken('MyApp')->plainTextToken,
            'name'  => $user->name,
        ];

        return Response($success, 200, ['Authorization' => $success['token']]);
    }

    /**
     * Login api
     */
    public function login(Request $request): Response
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $response = [
                'name'  => $user->name,
                'token' => $user->createToken('MyApp')->plainTextToken,
            ];

            return Response($response, 200, ['Authorization' => $response['token']]);
        }

        return Response(['error' => 'Unauthorised'], 401);
    }

    /**
     * Get logged user api
     */
    public function userInfo(): Response
    {
        return Response(Auth::user());
    }
}
