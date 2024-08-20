<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::prefix('v1')->as('v1:')->group(function () {
    Route::prefix('auth')->as('auth:')->group(base_path('routes/api/auth.php'));
});


// Task management Routes
Route::middleware([
    'auth:sanctum',
])->prefix('v1')->as('v1:')->group(function () {
    Route::prefix('tasks')->as('tasks:')->group(base_path('routes/api/tasks.php'));
});
