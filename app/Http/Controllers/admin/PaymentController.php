<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Course;
use App\Models\User;
use App\Notifications\UnpaidPaymentNotification;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['parent', 'course']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->get();
        $courses = Course::all();

        return view('dashboards.admin.payment.payments', compact('payments', 'courses'));
    }

    /**
     * Step 1: Select course, list parents & their kids.
     */
    public function create(Request $request)
    {
        $courses = Course::with('players.parent')->get();
        $selectedCourse = null;
        $parents = collect();

        if ($request->filled('course_id')) {
            $selectedCourse = Course::with(['players.parent'])->find($request->course_id);

            if ($selectedCourse) {
                $playersWithParents = $selectedCourse->players->filter(fn($player) => $player->parent);

                $parents = $playersWithParents->groupBy('parent_id')
                    ->map(function ($group) use ($selectedCourse) {
                        $parent = $group->first()->parent;

                        $existingPayment = $parent->payments()
                            ->where('course_id', $selectedCourse->id)
                            ->first();

                        return [
                            'parent' => $parent,
                            'children_count' => $group->count(),
                            'payment' => $existingPayment,
                        ];
                    })
                    ->values();
            }
        }

        return view('dashboards.admin.payment.payment-create', compact('courses', 'selectedCourse', 'parents'));
    }



    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:unpaid,partial,paid',
            'note' => 'nullable|string',
        ]);

        $payment->update([
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Payment updated successfully.');
    }

    /**
     * Step 2: Store all payments for selected parents.
     */
    public function storeMultiple(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payments' => 'required|array',
            'payments.*.parent_id' => 'required|exists:users,id',
            'payments.*.amount' => 'required|numeric|min:0',
            'payments.*.due_date' => 'nullable|date',
        ]);

        foreach ($validated['payments'] as $paymentData) {
            Payment::create([
                'parent_id' => $paymentData['parent_id'],
                'course_id' => $validated['course_id'],
                'amount' => $paymentData['amount'],
                'due_date' => $paymentData['due_date'] ?? null,
                'status' => 'unpaid',
            ]);
        }

        return redirect()->route('payments.index')->with('success', 'Payments created successfully for selected parents.');
    }

    public function notifyUnpaid(Request $request)
    {
        $unpaidPayments = Payment::with(['parent', 'course'])
            ->when($request->course_id, fn($q) => $q->where('course_id', $request->course_id))
            ->where('status', 'unpaid')
            ->get();

        foreach ($unpaidPayments as $payment) {
            $parent = $payment->parent;
            $course = $payment->course;

            if ($parent && $course) {
                $parent->notify(new UnpaidPaymentNotification(
                    $parent,
                    $course,
                    $payment->amount,
                    $payment->due_date ? $payment->due_date->format('Y-m-d') : 'N/A'
                ));
            }
        }

        return back()->with('success', 'Notifications sent to unpaid parents successfully.');
    }
}
