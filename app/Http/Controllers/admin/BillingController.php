<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Billing;
use App\Models\BillingExpense;
use App\Models\Payment;
use App\Models\Course;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingController extends Controller
{

    public function index()
    {
        $billings = Billing::with('course')->orderBy('created_at', 'desc')->get();
        $courses = Course::all();
        return view('dashboards.admin.billing.billings', compact('billings', 'courses'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $totalIncome = Payment::where('course_id', $request->course_id)
            ->where('status', 'paid')
            ->sum('amount');

        $billing = Billing::updateOrCreate(
            [
                'course_id' => $request->course_id,
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
        return redirect()->route('billings.index')->with('success', 'Billing deleted successfully.');
    }

    public function exportPdf($billingId)
    {
        $billing = Billing::with(['course', 'expenses'])->findOrFail($billingId);

        $pdf = Pdf::loadView('pdf.billing', [
            'billing' => $billing,
        ])->setPaper('a4', 'portrait');

        $filename = 'billing_' . $billing->id . '_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}
