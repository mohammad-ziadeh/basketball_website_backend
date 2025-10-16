<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4>Payments Management</h4>
                </div>

                <div class="d-flex gap-2">
                    <!-- Notify Unpaid Parents -->
                    <form method="POST" action="{{ route('payments.notifyUnpaid') }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fa-solid fa-bell"></i> Notify Unpaid Parents
                        </button>
                    </form>

                    <!-- Create Payment -->
                    <a href="{{ route('payments.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i> Create Payment
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('payments.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <select name="course_id" class="form-control">
                                <option value="">All Courses</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial
                                </option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <table id="payments-table" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Parent</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Payment Left</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Note</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->parent ? $payment->parent->name : 'N/A' }}</td>
                                <td>{{ $payment->course ? $payment->course->name : 'N/A' }}</td>
                                <td>${{ number_format($payment->amount, 2) }}</td>
                                <td>${{ number_format($payment->left_amount, 2) }}</td>
                                <td>{{ $payment->due_date ? $payment->due_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    @if ($payment->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif ($payment->status === 'partial')
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td>{{ $payment->note ?? '—' }}</td>
                                <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editPaymentModal{{ $payment->id }}">
                                        Edit
                                    </button>

                                    <div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1"
                                        aria-labelledby="editPaymentLabel{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('payments.update', $payment->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editPaymentLabel{{ $payment->id }}">Edit Payment
                                                            #{{ $payment->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="unpaid"
                                                                    {{ $payment->status === 'unpaid' ? 'selected' : '' }}>
                                                                    Unpaid</option>
                                                                <option value="partial"
                                                                    {{ $payment->status === 'partial' ? 'selected' : '' }}>
                                                                    Partial</option>
                                                                <option value="paid"
                                                                    {{ $payment->status === 'paid' ? 'selected' : '' }}>
                                                                    Paid</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Note</label>
                                                            <textarea name="note" class="form-control" rows="2">{{ $payment->note }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Payment Left</label>
                                                            <input name="left_amount" class="form-control" rows="2" value="{{ $payment->left_amount }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success">Save
                                                            Changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script>
            $(document).ready(function() {
                $('#payments-table').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    searching: false,
                    info: false,
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                });
            });
        </script>
    @endpush
</x-app-layout>
