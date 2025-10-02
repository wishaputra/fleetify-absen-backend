<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DepartmentController,EmployeeController,AttendanceController};

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('employees', EmployeeController::class);

Route::post('attendance/check-in', [AttendanceController::class,'checkIn']);
Route::put('attendance/check-out', [AttendanceController::class,'checkOut']);
Route::get('attendance/logs', [AttendanceController::class,'logs']);

Route::get('/', function () {
    return view('welcome');
});
