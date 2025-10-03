<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('employees', EmployeeController::class);

Route::post('attendance/check-in', [AttendanceController::class, 'checkIn']);
Route::put('attendance/check-out', [AttendanceController::class, 'checkOut']);
Route::get('attendance/logs', [AttendanceController::class, 'logs']);
