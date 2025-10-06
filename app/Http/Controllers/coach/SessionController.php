<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Course;
use Illuminate\Http\Request;

class SessionController extends Controller
{


    /**
     * Store a newly created session (lesson).
     */
    public function store(Request $request, $courseId)
    {
        $validated = $request->validate([
            'session_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
        ]);

        Session::create([
            'course_id' => $courseId,
            'session_date' => $validated['session_date'],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Session added successfully!');
    }


    /**
     * Update an existing session.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'session_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
        ]);

        $session = Session::findOrFail($id);
        $session->update($validated);

        return back()->with('success', 'Session updated successfully!');
    }

    /**
     * Delete a session.
     */
    public function destroy($id)
    {
        $session = Session::findOrFail($id);
        $session->delete();

        return back()->with('success', 'Session deleted successfully!');
    }
}
