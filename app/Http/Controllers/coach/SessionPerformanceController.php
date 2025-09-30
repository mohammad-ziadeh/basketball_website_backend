<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\SessionPerformance;
use Illuminate\Http\Request;
use App\Models\User;

class SessionPerformanceController extends Controller
{
    public function index()
{
    $players = User::where('role', 'player')->get();
    $sessions = SessionPerformance::with('player')->latest()->take(20)->get();
    return view('dashboards.coach.session_performance.index', compact('players', 'sessions'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'player_id' => 'required|exists:users,id',
            'session_date' => 'required|date',
            'score' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string'
        ]);

        SessionPerformance::create($data);
        return redirect()->back()->with('success', 'Session performance created successfully.');
    }

    public function show(SessionPerformance $sessionPerformance)
    {
        return $sessionPerformance->load('player')->orderBy('session_date' ,'desc');
    }

    public function update(Request $request, SessionPerformance $sessionPerformance)
    {
        $data = $request->validate([
            'player_id' => 'sometimes|exists:users,id',
            'session_date' => 'sometimes|date',
            'score' => 'sometimes|numeric|min:0|max:100',
            'remarks' => 'nullable|string'
        ]);

        $sessionPerformance->update($data);

        return redirect()->back()->with('success', 'Session performance updated successfully.');
    }

    public function destroy(SessionPerformance $sessionPerformance)
    {
        $sessionPerformance->delete();
        return response()->noContent();
    }
}