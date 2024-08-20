<?php

namespace App\Http\Controllers\V1;

use App\Contracts\HttpResponseInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use function Laravel\Prompts\error;

class UpdateTaskStatusController extends Controller
{
    public function __construct(public HttpResponseInterface $httpResponse)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateTaskStatusRequest $request)
    {
        $task = Task::query()->findOrFail($request->get('task_id'));

        $response = Gate::inspect('update-task-status', $task);

        if ($response->allowed()) {
            $user = User::query()->find($request->get('user_id'));

            if ($user->tasks()->find($request->get('task_id'))) {
                $user->tasks()->updateExistingPivot($request->get('task_id'), [
                    'status' => $request->get('status')
                ]);

                return $this->httpResponse->success(
                    message: 'Task status updated successfully.',
                    data: [
                        'status' => $request->get('status'),
                        'task' => $task
                    ]
                );
            } else {
                return $this->httpResponse->error(
                    errors: [
                        'task' => 'Task not found or not assigned to user.'
                    ],
                );
            }
        } else {
            return $this->httpResponse->error(
                errors: [
                    'permission' => 'You do not have permission to update task status.',
                ]
            );
        }
    }
}
