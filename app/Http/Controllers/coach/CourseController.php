<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('coach')->latest()->get();
        $coaches = User::where('role', 'coach')->get();
        $players = User::where('role', 'player')->get();
        return view('dashboards.coach.courses.course', compact('courses', 'coaches', 'players'));
    }

    public function create()
    {
        $coaches = User::where('role', 'coach')->get();
        $players = User::where('role', 'player')->get();
        return view('dashboards.coach.courses.course-create-modal', compact('coaches', 'players'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coach_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'player_ids' => 'array',
        ]);

        $course = Course::create($validated);
        $course->players()->sync($request->player_ids ?? []);

        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }
    public function edit(Course $course)
    {
        $coaches = User::where('role', 'coach')->get();
        $players = User::where('role', 'player')->get();
        $selectedPlayers = $course->players->pluck('id')->toArray();

        return view('dashboards.coach.courses.course-edit-modal', compact('course', 'coaches', 'players', 'selectedPlayers'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'coach_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'player_ids' => 'array',
        ]);

        $course->update($validated);
        $course->players()->sync($request->player_ids ?? []);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }

    public function addSession(Request $request, $courseId)
    {
        $request->validate([
            'session_date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
        ]);

        Session::create([
            'course_id' => $courseId,
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Session added successfully!');
    }
}
