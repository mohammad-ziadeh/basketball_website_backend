<?php

namespace App\Http\Controllers\coach;

use App\Models\Attendance;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'markedBy'])
            ->whereHas('user', function ($q) {
                $q->where('role', 'player');
            });


        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendance = $query->orderBy('attendance_date', 'desc')
            ->paginate(15)
            ->appends($request->only(['date', 'status']));

        return view('dashboards.coach.attendance.attendance', compact('attendance'));
    }


    public function create(Request $request)
    {
        $date = $request->date ?? now()->toDateString();
        $users = User::where('role', 'player')->get();

        $existingAttendance = Attendance::whereDate('attendance_date', $date)
            ->pluck('status', 'user_id');

        return view('dashboards.coach.attendance.attendance-create', compact('users', 'existingAttendance', 'date'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'attendance.*.user_id' => 'required|exists:users,id',
            'attendance.*.status' => 'required|in:present,absent,late',
            'date' => 'required|date',
        ]);

        foreach ($request->attendance as $att) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $att['user_id'],
                    'attendance_date' => $request->date,
                ],
                [
                    'status' => $att['status'],
                    'marked_by' => Auth::id(),
                ]
            );
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance saved successfully.');
    }


    public function edit(Attendance $attendance)
    {
        return view('dashboards.coach.attendance.attendance', compact('attendance'));
    }


    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance->update([
            'status' => $request->status,
            'marked_by' => Auth::id(),
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance deleted successfully.');
    }
}
