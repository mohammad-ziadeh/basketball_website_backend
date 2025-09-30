<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\MonthlyPerformance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\SessionPerformance;


class MonthlyPerformanceController extends Controller
{
    public function index()
    {
        $players = User::where('role', 'player')->get();
        return view('dashboards.coach.monthly_performances.monthly_performance', compact('players'));
    }


    public function calculate(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:users,id',
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12'
        ]);

        $monthly = MonthlyPerformance::calculateMonthly(
            $request->player_id,
            $request->year,
            $request->month
        );

        return $monthly;
    }

    public function show($playerId)
    {
        $player = User::findOrFail($playerId);

        $months = SessionPerformance::where('player_id', $playerId)
            ->selectRaw('YEAR(session_date) as year, MONTH(session_date) as month')
            ->groupBy('year', 'month')
            ->get();

        foreach ($months as $m) {
            MonthlyPerformance::calculateMonthly($playerId, $m->year, $m->month);
        }

        $monthlyRecords = MonthlyPerformance::where('player_id', $playerId)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('dashboards.coach.monthly_performances.monthly_performance-show', compact('player', 'monthlyRecords'));
    }



    public function destroy(MonthlyPerformance $monthlyPerformance)
    {
        $monthlyPerformance->delete();
        return response()->noContent();
    }

    public function exportPdf($monthlyId)
    {
        $monthlyPerformance = MonthlyPerformance::findOrFail($monthlyId);
        $sessions = SessionPerformance::where('player_id', $monthlyPerformance->player_id)
            ->whereYear('session_date', $monthlyPerformance->year)
            ->whereMonth('session_date', $monthlyPerformance->month)
            ->orderBy('session_date')
            ->get();

        $total = $sessions->sum('score');
        $average = $sessions->avg('score');

        $pdf = PDF::loadView('pdf.monthly_performance', [
            'monthlyPerformance' => $monthlyPerformance,
            'sessions' => $sessions,
            'total' => $total,
            'average' => round($average, 2),
        ]);

        return $pdf->download('monthly_performance_' . $monthlyPerformance->player_id . '_' . $monthlyPerformance->month . '_' . $monthlyPerformance->year . '.pdf');
    }
}
