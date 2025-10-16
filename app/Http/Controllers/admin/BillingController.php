<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Billing;
use App\Models\BillingExpense;
use App\Models\Payment;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    public function index()
    {
        $billings = Billing::with('course')->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        return view('dashboards.admin.billing.billings', compact('billings'));
    }

    public function create()
    {
        $courses = \App\Models\Course::all();
        return view('dashboards.admin.billing.billing-create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
        ]);

        // Sum all paid payments for this course
        $totalIncome = Payment::where('course_id', $request->course_id)
            ->where('status', 'paid')
            ->whereMonth('paid_at', $request->month)
            ->whereYear('paid_at', $request->year)
            ->sum('amount');

        // Create billing
        $billing = Billing::updateOrCreate(
            [
                'course_id' => $request->course_id,
                'month' => $request->month,
                'year' => $request->year,
            ],
            [
                'total_income' => $totalIncome,
                'total_expenses' => 0,
                'final_payment' => $totalIncome,
            ]
        );

        return redirect()->route('billings.edit', $billing->id)
            ->with('success', 'Billing created successfully.');
    }

    public function edit(Billing $billing)
    {
        return view('dashboards.admin.billing.billing-edit', compact('billing'));
    }

    public function addExpense(Request $request, Billing $billing)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $expense = $billing->expenses()->create($request->only('name', 'amount'));

        // Update totals
        $billing->total_expenses = $billing->expenses()->sum('amount');
        $billing->final_payment = $billing->total_income - $billing->total_expenses;
        $billing->save();

        return back()->with('success', 'Expense added successfully.');
    }

    public function updateExpense(Request $request, BillingExpense $expense)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $expense->update($request->only('name', 'amount'));

        $billing = $expense->billing;
        $billing->total_expenses = $billing->expenses()->sum('amount');
        $billing->final_payment = $billing->total_income - $billing->total_expenses;
        $billing->save();

        return back()->with('success', 'Expense updated successfully.');
    }

    public function destroy(Billing $billing)
    {
        $billing->delete();
        return redirect()->route('billing.index')->with('success', 'Billing deleted successfully.');
    }
}
