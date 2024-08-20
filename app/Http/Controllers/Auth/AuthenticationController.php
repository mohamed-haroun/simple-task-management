<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\HttpResponseInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function __construct(
        public HttpResponseInterface $httpResponse
    )
    {
    }

    /**
     * Handle an incoming authentication request.
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $user = $request->authenticate();

        if ($user) {
            // Creating token for the logged in user
            $token = $user->createToken(config('app.name'))->plainTextToken;

            return $this->httpResponse->success(
                message: 'You have successfully logged in.',
                data: [
                    'token' => $token,
                    'user' => $user,
                ],

            );
        } else {
            throw ValidationException::withMessages([
                'login' => [trans('auth.failed')],
            ]);
        }


    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->user()->tokens()->delete();

        return $this->httpResponse->success(
            message: 'You have successfully logged out.',
        );
    }
}
