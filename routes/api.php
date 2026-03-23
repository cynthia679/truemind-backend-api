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

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Courses CRUD
    Route::apiResource('courses', CoursesController::class);

    // Assignments nested under courses
    Route::apiResource('courses.assignments', AssignmentsController::class);

    // Submissions nested under assignments
    Route::apiResource('assignments.submissions', SubmissionsController::class);

    // Progress (students view their own progress)
    Route::get('/progress', [ProgressController::class, 'index']); // all progress for logged-in student
    Route::get('/progress/course/{courseId}', [ProgressController::class, 'showByCourse']); // progress for specific course
    Route::put('/progress/course/{courseId}', [ProgressController::class, 'updateByCourse']); // update progress for course

    // Notifications
    Route::get('/notifications', [NotificationsController::class, 'index']);
    Route::get('/notifications/{notification}', [NotificationsController::class, 'show']);
    Route::put('/notifications/{notification}', [NotificationsController::class, 'update']);
});
