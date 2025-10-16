<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="card">
            <div class="card-header">
                <h4>Create Payments</h4>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('payments.create') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <select name="course_id" class="form-control" required>
                                <option value="">-- Select Course --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Load Parents</button>
                        </div>
                    </div>
                </form>

                @if ($selectedCourse)
                    <form method="POST" action="{{ route('payments.storeMultiple') }}">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Parent Name</th>
                                    <th>Children Count</th>
                                    <th>Amount (USD)</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parents as $data)
                                    @php
                                        $existingPayment = $data['parent']
                                            ->payments()
                                            ->where('course_id', $selectedCourse->id)
                                            ->first();
                                    @endphp

                                    <tr>
                                        <td>
                                            {{ $data['parent']->name }}
                                            <input type="hidden" name="payments[{{ $loop->index }}][parent_id]"
                                                value="{{ $data['parent']->id }}">
                                        </td>
                                        <td>{{ $data['children_count'] }}</td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control"
                                                name="payments[{{ $loop->index }}][amount]" required
                                                value="{{ $existingPayment->amount ?? '' }}">
                                        </td>
                                        @if ($existingPayment)
                                            <td>
                                                <input type="date" class="form-control"
                                                    name="payments[{{ $loop->index }}][due_date]"
                                                    value="{{ $existingPayment->due_date?->format('Y-m-d') ?? now() }}">
                                            </td>
                                        @else
                                            <td>
                                                <input type="date" class="form-control"
                                                    name="payments[{{ $loop->index }}][due_date]">
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">Save Payments</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
