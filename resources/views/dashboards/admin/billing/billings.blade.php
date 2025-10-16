<x-app-layout>
    @include('components.alerts')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">

        <a href="{{ route('billings.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Create New Billing
        </a>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($billings as $billing)
                    <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg mb-2">{{ $billing->course->name }}</h3>
                            <p><strong>Month/Year:</strong> {{ $billing->month }}/{{ $billing->year }}</p>
                            <p><strong>Total Income:</strong> ${{ number_format($billing->total_income, 2) }}</p>
                            <p><strong>Total Expenses:</strong> ${{ number_format($billing->total_expenses, 2) }}</p>
                            <p><strong>Final Payment:</strong> ${{ number_format($billing->final_payment, 2) }}</p>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('billings.edit', $billing->id) }}"
                                class="flex-1 bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 text-center">
                                Edit
                            </a>
                            <form action="{{ route('billings.destroy', $billing->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this billing?');"
                                class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
