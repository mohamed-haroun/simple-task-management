<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\HttpResponseInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function __construct(
        public HttpResponseInterface $httpResponse
    )
    {
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'user',
            'password' => Hash::make($request->string('password')),
        ]);

        event(new Registered($user));

        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->httpResponse->success(
                message: 'User created successfully',
                data: [
                    'token' => $token,
                    'user' => $user,
                ],
            );
        } else {
            return $this->httpResponse->error(
                message: 'Something went wrong',
            );
        }
    }
}
