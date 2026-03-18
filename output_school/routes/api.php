<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EnrollmentsController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubmissionsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserRolesController;

Route::apiResource('/announcements', AnnouncementsController::class);
Route::apiResource('/assignments', AssignmentsController::class);
Route::apiResource('/classrooms', ClassroomsController::class);
Route::apiResource('/courses', CoursesController::class);
Route::apiResource('/departments', DepartmentsController::class);
Route::apiResource('/enrollments', EnrollmentsController::class);
Route::apiResource('/grades', GradesController::class);
Route::apiResource('/payments', PaymentsController::class);
Route::apiResource('/roles', RolesController::class);
Route::apiResource('/schedules', SchedulesController::class);
Route::apiResource('/students', StudentsController::class);
Route::apiResource('/submissions', SubmissionsController::class);
Route::apiResource('/teachers', TeachersController::class);
Route::apiResource('/users', UsersController::class);
Route::apiResource('/user_roles', UserRolesController::class);
