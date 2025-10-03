<?php

namespace App\Http\Controllers\Parent;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ChildAttendanceController extends Controller
{
    public function index()
    {
        $parent = User::with('children')->where('role', 'parent')
            ->where('id', Auth::id())
            ->first();

        if (!$parent) {
            return redirect()->route('login');
        }


        $children = $parent->children()
            ->with(['attendance' => function ($q) {
                $q->orderBy('attendance_date', 'desc');
            }])
            ->get();

        return view('dashboards.parent.children-attendance.attendance', compact('children'));
    }
}
