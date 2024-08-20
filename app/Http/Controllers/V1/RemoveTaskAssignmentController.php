<?php

namespace App\Http\Controllers\V1;

use App\Contracts\HttpResponseInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\RemoveTaskAssignmentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RemoveTaskAssignmentController extends Controller
{
    public function __construct(public HttpResponseInterface $httpResponse)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(RemoveTaskAssignmentRequest $request)
    {
        $response = Gate::inspect('remove-task', $request->user());

        if ($response->allowed()) {
            User::query()
                ->find($request->input('user_id'))
                ->tasks()
                ->detach(
                    ids: [$request->input('task_id')]
                );

            return $this->httpResponse->success(
                message: 'Task assignment removed.',
            );
        } else {
            return $this->httpResponse->error(
                errors: [
                    'permission' => $response->message()
                ]
            );
        }
    }
}
