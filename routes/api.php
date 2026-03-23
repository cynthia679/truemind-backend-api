<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\SubmissionsController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\NotificationsController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require token)
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Courses
    Route::get('/courses', [CoursesController::class, 'index']);        // List all courses
    Route::get('/courses/{course}', [CoursesController::class, 'show']); // Show single course
    Route::post('/courses', [CoursesController::class, 'store']);       // Create course
    Route::put('/courses/{course}', [CoursesController::class, 'update']); // Update course
    Route::delete('/courses/{course}', [CoursesController::class, 'destroy']); // Delete course

    // Assignments
    Route::get('/assignments', [AssignmentsController::class, 'index']);
    Route::get('/assignments/{assignment}', [AssignmentsController::class, 'show']);
    Route::post('/assignments', [AssignmentsController::class, 'store']);
    Route::put('/assignments/{assignment}', [AssignmentsController::class, 'update']);
    Route::delete('/assignments/{assignment}', [AssignmentsController::class, 'destroy']);

    // Submissions
    Route::get('/submissions', [SubmissionsController::class, 'index']);
    Route::get('/submissions/{submission}', [SubmissionsController::class, 'show']);
    Route::post('/submissions', [SubmissionsController::class, 'store']);
    Route::put('/submissions/{submission}', [SubmissionsController::class, 'update']);
    Route::delete('/submissions/{submission}', [SubmissionsController::class, 'destroy']);

    // Progress
    Route::get('/progress', [ProgressController::class, 'index']);
    Route::get('/progress/{progress}', [ProgressController::class, 'show']);
    Route::post('/progress', [ProgressController::class, 'store']);
    Route::put('/progress/{progress}', [ProgressController::class, 'update']);

    // Notifications
    Route::get('/notifications', [NotificationsController::class, 'index']);
    Route::get('/notifications/{notification}', [NotificationsController::class, 'show']);
    Route::post('/notifications', [NotificationsController::class, 'store']);
    Route::put('/notifications/{notification}', [NotificationsController::class, 'update']);
    Route::delete('/notifications/{notification}', [NotificationsController::class, 'destroy']);
});
