<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\HttpResponseInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function __construct(
        public HttpResponseInterface $httpResponse
    )
    {
    }
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->httpResponse->success(
                message: 'Email already verified'
            );
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->httpResponse->success(
            message: 'Email verification notification sent',
            data: [
                'status' => 'verification-link-sent'
            ]);
    }
}
