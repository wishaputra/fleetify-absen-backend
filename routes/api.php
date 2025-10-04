<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DepartementController, EmployeeController, AttendanceController};

Route::apiResource('departments', DepartementController::class);
Route::apiResource('employees', EmployeeController::class);

Route::post('attendance/check-in', [AttendanceController::class, 'checkIn']);
Route::put('attendance/check-out', [AttendanceController::class, 'checkOut']);
Route::get('attendance/logs', [AttendanceController::class, 'logs']);
