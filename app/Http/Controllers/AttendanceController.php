<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceCheckRequest;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(AttendanceCheckRequest $r)
    {
        $employee = Employee::with('department')->findOrFail($r->employee_id);
        $now  = $r->timestamp ? Carbon::parse($r->timestamp) : now();
        $date = $r->work_date ? Carbon::parse($r->work_date)->toDateString() : $now->toDateString();

        $attendance = Attendance::firstOrCreate(['employee_id'=>$employee->id,'work_date'=>$date]);

        if (!$attendance->check_in_at) {
            $attendance->check_in_at = $now;
            $deadlineIn = Carbon::parse($date.' '.$employee->department->max_checkin_time);
            if ($now->lte($deadlineIn)) {
                $attendance->status_in = 'on_time';
                $attendance->late_minutes = 0;
            } else {
                $attendance->status_in = 'late';
                $attendance->late_minutes = $deadlineIn->diffInMinutes($now);
            }
            $attendance->save();
        }

        return $attendance->load('employee.department');
    }

    public function checkOut(AttendanceCheckRequest $r)
    {
        $employee = Employee::with('department')->findOrFail($r->employee_id);
        $now  = $r->timestamp ? Carbon::parse($r->timestamp) : now();
        $date = $r->work_date ? Carbon::parse($r->work_date)->toDateString() : $now->toDateString();

        $attendance = Attendance::firstOrCreate(['employee_id'=>$employee->id,'work_date'=>$date]);

        $attendance->check_out_at = $now;
        $deadlineOut = Carbon::parse($date.' '.$employee->department->max_checkout_time);
        if ($now->gte($deadlineOut)) {
            $attendance->status_out = 'on_time';
            $attendance->early_leave_minutes = 0;
        } else {
            $attendance->status_out = 'early_leave';
            $attendance->early_leave_minutes = $now->diffInMinutes($deadlineOut);
        }
        $attendance->save();

        return $attendance->load('employee.department');
    }

    public function logs(Request $r)
    {
        $q = Attendance::with(['employee.department'])
            ->when($r->employee_id, fn($x)=>$x->where('employee_id',$r->employee_id))
            ->when($r->department_id, fn($x)=>$x->whereHas('employee', fn($y)=>$y->where('department_id',$r->department_id)))
            ->when($r->date_from, fn($x)=>$x->whereDate('work_date','>=',$r->date_from))
            ->when($r->date_to,   fn($x)=>$x->whereDate('work_date','<=',$r->date_to))
            ->orderByDesc('work_date');

        return $q->paginate(20);
    }
}
