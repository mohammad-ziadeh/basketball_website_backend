<x-app-layout>
    @include('components.alerts')

    <div class="container-fluid py-5 min-vh-100">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-cash-stack text-success"></i> Billing & Expense Dashboard
                </h2>
                <p class="text-muted mb-0">Track and manage all billing records with detailed financial metrics</p>
            </div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createBillingModal">
                <i class="bi bi-plus-circle"></i> New Billing
            </button>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-success-subtle p-3 d-inline-flex mb-3">
                            <i class="bi bi-graph-up text-success fs-3"></i>
                        </div>
                        <h6 class="text-muted mb-1">Total Income</h6>
                        <h3 class="fw-bold text-success">${{ number_format($billings->sum('total_income'), 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-danger-subtle p-3 d-inline-flex mb-3">
                            <i class="bi bi-wallet2 text-danger fs-3"></i>
                        </div>
                        <h6 class="text-muted mb-1">Total Expenses</h6>
                        <h3 class="fw-bold text-danger">${{ number_format($billings->sum('total_expenses'), 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-primary-subtle p-3 d-inline-flex mb-3">
                            <i class="bi bi-currency-dollar text-primary fs-3"></i>
                        </div>
                        <h6 class="text-muted mb-1">Net Revenue</h6>
                        <h3 class="fw-bold text-primary">${{ number_format($billings->sum('final_payment'), 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse ($billings as $billing)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 billing-card position-relative overflow-hidden">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <h5 class="fw-bold  mb-1 text-xl">
                                    {{ $billing->course->name }}
                                </h5>
                                <small class="text-muted">Billing ID:
                                    #{{ str_pad($billing->id, 4, '0', STR_PAD_LEFT) }}</small>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted fw-semibold">Total Income</span>
                                    <span
                                        class="text-success fw-bold">${{ number_format($billing->total_income, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted fw-semibold">Total Expenses</span>
                                    <span
                                        class="text-danger fw-bold">${{ number_format($billing->total_expenses, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2">
                                    <span class="fw-bold">Final Payment</span>
                                    <span
                                        class="fw-bold text-primary">${{ number_format($billing->final_payment, 2) }}</span>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="{{ route('billings.edit', $billing->id) }}" class="btn btn-outline-primary">
                                    Edit
                                </a>
                                <a href="{{ route('billings.exportPdf', $billing->id) }}"
                                    class="btn btn-outline-success">
                                    Export PDF
                                </a>
                                <form action="{{ route('billings.destroy', $billing->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this billing?');"
                                    class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>
                            </div>

                        </div>
                        <div class="card-footer bg-light text-center small text-muted">
                            Last Updated: {{ $billing->updated_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <h5 class="text-muted mt-3">No billing records found.</h5>
                    <button class="btn btn-outline-success mt-3 rounded-pill px-4" data-bs-toggle="modal"
                        data-bs-target="#createBillingModal">
                        <i class="bi bi-plus-circle"></i> Create your first billing
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- create modal --}}
    @include('dashboards.admin.billing.billing-create-modal')

    <style>
        .billing-card {
            transition: all 0.3s ease;
        }

        .billing-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 1.2rem 2rem rgba(0, 0, 0, 0.1);
        }

        .modal-content {
            border-radius: 1rem;
        }
    </style>
</x-app-layout>
