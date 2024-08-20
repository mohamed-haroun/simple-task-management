<?php

namespace App\Http\Controllers\V1;

use App\Contracts\HttpResponseInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskAssignmentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskAssignmentController extends Controller
{
    public function __construct(public HttpResponseInterface $httpResponse)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreTaskAssignmentRequest $request)
    {
        $response = Gate::inspect('assign-task', $request->user());

        if ($response->allowed()) {
            User::query()
                ->find($request->input('user_id'))
                ->tasks()
                ->attach($request->input('task_id'));

            return $this->httpResponse->success(
                message: 'Task Assigned successfully.',
            );
        } else {
            return $this->httpResponse->error(
                errors: [
                    'permission' => $response->message(),
                ]
            );
        }

    }
}
