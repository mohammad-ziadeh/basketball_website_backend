<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Billing for {{ $billing->course->name }} ({{ $billing->month }}/{{ $billing->year }})
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="font-semibold mb-2">Summary</h3>
                <p><strong>Total Income:</strong> ${{ number_format($billing->total_income, 2) }}</p>
                <p><strong>Total Expenses:</strong> ${{ number_format($billing->total_expenses, 2) }}</p>
                <p><strong>Final Payment:</strong> ${{ number_format($billing->final_payment, 2) }}</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="font-semibold mb-4">Add Expense</h3>
                <form action="{{ route('billings.addExpense', $billing->id) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Expense Name" class="border rounded p-2 flex-1">
                    <input type="number" name="amount" step="0.01" placeholder="Amount" class="border rounded p-2 w-32">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add</button>
                </form>
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold mb-4">Expenses</h3>
                <table class="w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Amount</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billing->expenses as $expense)
                        <tr>
                            <form action="{{ route('billings.updateExpense', $expense->id) }}" method="POST">
                                @csrf
                                <td class="border px-4 py-2">
                                    <input type="text" name="name" value="{{ $expense->name }}" class="border rounded p-1 w-full">
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="number" name="amount" value="{{ $expense->amount }}" step="0.01" class="border rounded p-1 w-full">
                                </td>
                                <td class="border px-4 py-2">
                                    <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Update</button>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
