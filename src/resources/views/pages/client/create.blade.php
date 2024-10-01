@extends('layout.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold mb-6">Add New Client</h1>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pages.client.store') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    class="w-full p-2 border border-gray-300 rounded-lg @error('first_name') border-red-500 @enderror"
                    value="{{ old('first_name') }}"
                    required
                >
                @error('first_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    class="w-full p-2 border border-gray-300 rounded-lg @error('last_name') border-red-500 @enderror"
                    value="{{ old('last_name') }}"
                    required
                >
                @error('last_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Client</button>
        </form>
    </div>
@endsection
