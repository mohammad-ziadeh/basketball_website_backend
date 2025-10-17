<x-app-layout>
    <div class="container-fluid py-5 min-vh-100">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold  mb-1">
                    <i class="bi bi-receipt-cutoff text-primary"></i>
                    Billing for {{ $billing->course->name }}
                </h2>
            </div>
            <a href="{{ route('billings.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back to All Billings
            </a>
        </div>

        @include('components.alerts')

        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-body">
                <h4 class="fw-bold  mb-4">
                    <i class="bi bi-bar-chart-fill text-success"></i> Summary
                </h4>
                <div class="row text-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="p-3 rounded-4 bg-success-subtle">
                            <h6 class="text-muted mb-1">Total Income</h6>
                            <h4 class="fw-bold text-success mb-0">
                                ${{ number_format($billing->total_income, 2) }}
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="p-3 rounded-4 bg-danger-subtle">
                            <h6 class="text-muted mb-1">Total Expenses</h6>
                            <h4 class="fw-bold text-danger mb-0">
                                ${{ number_format($billing->total_expenses, 2) }}
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 bg-primary-subtle">
                            <h6 class="text-muted mb-1">Final Payment</h6>
                            <h4 class="fw-bold text-primary mb-0">
                                ${{ number_format($billing->final_payment, 2) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-body">
                <h4 class="fw-bold  mb-4">
                    <i class="bi bi-plus-circle text-success"></i> Add Expense
                </h4>

                <form action="{{ route('billings.addExpense', $billing->id) }}" method="POST"
                    class="row g-3 align-items-center">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="name" class="form-control rounded-4" id="expenseName"
                                placeholder="Expense Name">
                            <label for="expenseName">Expense Name</label>
                        </div>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="number" name="amount" step="0.01" class="form-control rounded-4"
                                id="expenseAmount" placeholder="Amount">
                            <label for="expenseAmount">Amount ($)</label>
                        </div>
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 text-md-end">
                        <button type="submit" class="btn btn-success btn-lg  ">
                            <i class="bi bi-plus-lg"></i> Add Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="fw-bold  mb-4">
                    <i class="bi bi-wallet2 text-danger"></i> Expenses
                </h4>

                @if ($billing->expenses->count())
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($billing->expenses as $expense)
                                    <tr>
                                        <form action="{{ route('billings.updateExpense', $expense->id) }}"
                                            method="POST">
                                            @csrf
                                            <td>
                                                <input type="text" name="name" value="{{ $expense->name }}"
                                                    class="form-control form-control-sm rounded-3">
                                            </td>
                                            <td>
                                                <input type="number" name="amount" value="{{ $expense->amount }}"
                                                    step="0.01" class="form-control form-control-sm rounded-3">
                                            </td>
                                            <td class="text-end">
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                                    <i class="bi bi-pencil-square me-1"></i> Update
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <h6>No expenses added yet.</h6>
                    </div>
                @endif
            </div>
        </div>

    </div>


</x-app-layout>
