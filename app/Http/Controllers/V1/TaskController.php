<?php

namespace App\Http\Controllers\V1;

use App\Contracts\HttpResponseInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function __construct(public HttpResponseInterface $httpResponse)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Task::class);

        if ($request->user()->role == 'admin' || $request->user()->role == 'super_admin') {
            $tasks = Task::all();
        } else {
            $tasks = $request->user()->tasks;
        }

        return $this->httpResponse->success(
            data: [
                'tasks' => $tasks
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $response = Gate::inspect('create', Task::class);

        if ($response->allowed()) {
            $task = Task::query()->create($request->all());

            return $this->httpResponse->success(
                message: 'Task created successfully.',
                data: [
                    'task' => $task
                ]
            );
        } else {
            return $this->httpResponse->error(
                errors: [
                    'permission' => $response->message()
                ]
            );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $this->httpResponse->success(
            data: [
                'task' => $task
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $response = Gate::inspect('update', $task);

        if ($response->allowed()) {
            $task->update($request->validated());

            return $this->httpResponse->success(
                message: 'Task updated successfully.',
                data: [
                    'task' => $task
                ]
            );
        } else {
            return $this->httpResponse->error(
                errors: [
                    'permission' => $response->message()
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $response = Gate::inspect('delete', $task);

        if ($response->allowed()) {
            $task->delete();
            return $this->httpResponse->success(
                message: 'Task deleted successfully.'
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
