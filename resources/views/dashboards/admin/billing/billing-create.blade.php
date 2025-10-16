<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Billing
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('billings.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700">Course</label>
                        <select name="course_id" class="w-full border rounded p-2">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 flex gap-4">
                        <div>
                            <label class="block font-medium text-gray-700">Month</label>
                            <input type="number" name="month" min="1" max="12" class="w-full border rounded p-2" value="{{ old('month') }}">
                            @error('month') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700">Year</label>
                            <input type="number" name="year" min="2000" class="w-full border rounded p-2" value="{{ old('year', date('Y')) }}">
                            @error('year') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Create Billing
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
