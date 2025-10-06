<?php

namespace App\Http\Controllers\Coach;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Course;
use App\Models\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ChildAbsentNotification;

class AttendanceController extends Controller
{
    /**
     * Show attendance list with filters.
     */
    public function index(Request $request)
    {
        $courses = Course::with('sessions')->get();

        $query = Attendance::with(['user', 'markedBy', 'course', 'session'])
            ->whereHas('user', function ($q) {
                $q->where('role', 'player');
            });

        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('session_id')) {
            $query->where('session_id', $request->session_id);
        }

        $attendance = $query->orderBy('attendance_date', 'desc')
            ->paginate(15)
            ->appends($request->only(['date', 'status', 'course_id', 'session_id']));

        return view('dashboards.coach.attendance.attendance', compact('attendance', 'courses'));
    }

    /**
     * Show attendance creation page.
     */
    public function create(Request $request)
    {
        $date = $request->date ?? now()->toDateString();
        $courseId = $request->course_id;
        $sessionId = $request->session_id;

        $courses = Course::with('sessions', 'players')->get();
        $sessions = collect();

        if ($courseId) {
            $course = Course::with('players')->find($courseId);
            $users = $course ? $course->players : collect();
            $sessions = $course ? $course->sessions : collect();
        } else {
            $users = User::where('role', 'player')->get();
        }

        $existingAttendance = Attendance::whereDate('attendance_date', $date)
            ->when($courseId, fn($q) => $q->where('course_id', $courseId))
            ->pluck('status', 'user_id');

        return view('dashboards.coach.attendance.attendance-create', compact(
            'users',
            'existingAttendance',
            'date',
            'courses',
            'courseId',
            'sessions',
            'sessionId'
        ));
    }

    /**
     * Store or update attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attendance.*.user_id' => 'required|exists:users,id',
            'attendance.*.status' => 'required|in:present,absent,late',
            'course_id' => 'nullable|exists:courses,id',
            'session_id' => 'required|exists:sessions,id', // session is required now
        ]);

        // Get the session date
        $session = Session::findOrFail($request->session_id);
        $attendanceDate = $session->session_date;

        foreach ($request->attendance as $att) {
            $attendance = Attendance::updateOrCreate(
                [
                    'user_id' => $att['user_id'],
                    'attendance_date' => $attendanceDate, // use session date
                    'course_id' => $request->course_id,
                    'session_id' => $request->session_id,
                ],
                [
                    'status' => $att['status'],
                    'marked_by' => Auth::id(),
                ]
            );

            if ($attendance->status === 'absent') {
                $child = User::find($attendance->user_id);
                if ($child && $child->parent) {
                    $child->parent->notify(
                        new ChildAbsentNotification($child, $attendanceDate, $att['status'])
                    );
                }
            }
        }

        return back()->with('success', 'Attendance saved successfully.');
    }


    /**
     * Edit a single attendance record.
     */
    public function edit(Attendance $attendance)
    {
        return view('dashboards.coach.attendance.attendance', compact('attendance'));
    }

    /**
     * Update a single attendance record.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance->update([
            'status' => $request->status,
            'marked_by' => Auth::id(),
        ]);

        return redirect()->route('coach.attendance.index')
            ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Delete an attendance record.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('coach.attendance.index')
            ->with('success', 'Attendance deleted successfully.');
    }
}
