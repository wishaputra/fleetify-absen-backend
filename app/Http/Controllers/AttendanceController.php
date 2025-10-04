<?php

namespace App\Http\Controllers;

use App\Models\{Attendance, AttendanceHistory, Employee};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // POST /api/attendance/check-in
    public function checkIn(Request $r)
    {
        $data = $r->validate([
            'employee_id' => ['required','string','max:50'], // ex: EMP001
            'timestamp'   => ['nullable','date'],
        ]);

        $emp = Employee::where('employee_id',$data['employee_id'])->firstOrFail();
        $now = isset($data['timestamp']) ? Carbon::parse($data['timestamp']) : now();

        // attendance "hari ini" berdasarkan created_at tanggal
        $attendance = Attendance::where('employee_id',$emp->employee_id)
            ->whereDate('created_at',$now->toDateString())
            ->first();

        if (!$attendance) {
            $attendance = Attendance::create([
                'employee_id'   => $emp->employee_id,
                'attendance_id' => (string) Str::uuid(),
                'clock_in'      => $now,
            ]);
        } elseif (!$attendance->clock_in) {
            $attendance->update(['clock_in' => $now]);
        }

        AttendanceHistory::create([
            'employee_id'     => $emp->employee_id,
            'attendance_id'   => $attendance->attendance_id,
            'date_attendance' => $now,
            'attendance_type' => 1, // in
            'description'     => 'Check-in',
        ]);

        return $attendance;
    }

    // PUT /api/attendance/check-out
    public function checkOut(Request $r)
    {
        $data = $r->validate([
            'employee_id' => ['required','string','max:50'],
            'timestamp'   => ['nullable','date'],
        ]);

        $emp = Employee::where('employee_id',$data['employee_id'])->firstOrFail();
        $now = isset($data['timestamp']) ? Carbon::parse($data['timestamp']) : now();

        $attendance = Attendance::where('employee_id',$emp->employee_id)
            ->whereDate('created_at',$now->toDateString())
            ->latest('id')->first();

        if (!$attendance) {
            $attendance = Attendance::create([
                'employee_id'   => $emp->employee_id,
                'attendance_id' => (string) Str::uuid(),
                'clock_out'     => $now,
            ]);
        } else {
            $attendance->update(['clock_out' => $now]);
        }

        AttendanceHistory::create([
            'employee_id'     => $emp->employee_id,
            'attendance_id'   => $attendance->attendance_id,
            'date_attendance' => $now,
            'attendance_type' => 2, // out
            'description'     => 'Check-out',
        ]);

        return $attendance;
    }

    // GET /api/attendance/logs?date_from&date_to&department_id
    public function logs(Request $r)
    {
        $from = $r->query('date_from');
        $to   = $r->query('date_to');
        $dept = $r->query('department_id');

        $q = DB::table('attendance')
            ->join('employee', 'employee.employee_id', '=', 'attendance.employee_id')
            ->join('departement', 'departement.id', '=', 'employee.departement_id')
            ->selectRaw("
                attendance.id,
                attendance.employee_id,
                employee.name as employee_name,
                departement.departement_name,
                departement.max_clock_in_time,
                departement.max_clock_out_time,
                DATE(attendance.created_at) as work_date,
                attendance.clock_in,
                attendance.clock_out
            ")
            ->when($from, fn($x)=>$x->whereDate('attendance.created_at','>=',$from))
            ->when($to,   fn($x)=>$x->whereDate('attendance.created_at','<=',$to))
            ->when($dept, fn($x)=>$x->where('departement.id',$dept))
            ->orderByDesc('attendance.created_at');

        $data = $q->paginate(20);

        // hitung ketepatan secara derived
        $data->getCollection()->transform(function ($row) {
            $workDate = Carbon::parse($row->work_date)->toDateString();
            $deadlineIn  = Carbon::parse($workDate.' '.$row->max_clock_in_time);
            $deadlineOut = Carbon::parse($workDate.' '.$row->max_clock_out_time);

            $statusIn = 'absent'; $lateMin = 0;
            if ($row->clock_in) {
                $ci = Carbon::parse($row->clock_in);
                if ($ci->lte($deadlineIn)) $statusIn = 'on_time';
                else { $statusIn = 'late'; $lateMin = $deadlineIn->diffInMinutes($ci); }
            }

            $statusOut = 'not_checked_out'; $earlyMin = 0;
            if ($row->clock_out) {
                $co = Carbon::parse($row->clock_out);
                if ($co->gte($deadlineOut)) $statusOut = 'on_time';
                else { $statusOut = 'early_leave'; $earlyMin = $co->diffInMinutes($deadlineOut); }
            }

            return [
                'id' => $row->id,
                'work_date' => $workDate,
                'employee' => [
                    'id'   => $row->employee_id,
                    'name' => $row->employee_name,
                    'department' => $row->departement_name,
                ],
                'clock_in'  => $row->clock_in,
                'status_in' => $statusIn,
                'late_minutes' => $lateMin,
                'clock_out' => $row->clock_out,
                'status_out'=> $statusOut,
                'early_leave_minutes' => $earlyMin,
            ];
        });

        return $data;
    }
}
