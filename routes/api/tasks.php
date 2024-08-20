<?php

use App\Http\Controllers\V1\RemoveTaskAssignmentController;
use App\Http\Controllers\V1\TaskAssignmentController;
use App\Http\Controllers\V1\TaskController;
use App\Http\Controllers\V1\UpdateTaskStatusController;
use Illuminate\Support\Facades\Route;


// Tasks management
Route::apiResource('tasks', TaskController::class)
    ->missing(function (\Illuminate\Http\Request $request) {
        return response()->json([
            'message' => "Task with id " . $request->task . " not found."
        ]);
    });

// Tasks assignment management
Route::post('assignment/assign', TaskAssignmentController::class)->name('tasks.assignment.assign');
Route::post('assignment/unassign', RemoveTaskAssignmentController::class)->name('tasks.assignment.unassign');

/**
 * Update task status by user assigned by tasks or admin creating a task
 */
Route::post('status/change', UpdateTaskStatusController::class)->name('tasks.status.change');
