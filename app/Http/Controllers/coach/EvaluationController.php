<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\User;

class EvaluationController extends Controller
{
    public function index()
    {
        $users = User::with(['evaluations' => function ($query) {
            $query->where('evaluator_id', auth()->id()); // optional: filter by current evaluator
        }])->get();

        return view('dashboards.coach.evaluation.evaluations', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'skill_level' => 'required|integer|min:0|max:10',
            'fitness_level' => 'required|integer|min:0|max:10',
            'discipline_level' => 'required|integer|min:0|max:10',
            'notes' => 'nullable|string',
        ]);

        Evaluation::create([
            'user_id' => $request->user_id,
            'evaluator_id' => auth()->id(),
            'skill_level' => $request->skill_level,
            'fitness_level' => $request->fitness_level,
            'discipline_level' => $request->discipline_level,
            'notes' => $request->notes,
        ]);

        return redirect()->route('evaluations.index')->with('success', 'Evaluation created successfully.');
    }


    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'skill_level' => 'required|integer|min:0|max:10',
            'fitness_level' => 'required|integer|min:0|max:10',
            'discipline_level' => 'required|integer|min:0|max:10',
            'notes' => 'nullable|string',
        ]);

        $evaluation->update([
            'user_id' => $request->user_id,
            'evaluator_id' => auth()->id(),
            'skill_level' => $request->skill_level,
            'fitness_level' => $request->fitness_level,
            'discipline_level' => $request->discipline_level,
            'notes' => $request->notes,
        ]);

        return redirect()->route('evaluations.index')->with('success', 'Evaluation updated successfully.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')->with('success', 'Evaluation deleted successfully.');
    }
}
