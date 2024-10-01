@extends('layout.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold mb-6">Add New Client</h1>

        <form action="{{ route('pages.client.store') }}" method="POST" class="bg-white p-4 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" id="first_name" name="first_name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Client</button>
        </form>
    </div>
@endsection
