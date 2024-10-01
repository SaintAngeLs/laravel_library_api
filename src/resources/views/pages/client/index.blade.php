@extends('layout.app')

@section('content')
    <div class="container mx-auto px-4 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Clients</h1>
            <a href="{{ route('pages.client.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition ease-in-out duration-200">
                + Add New Client
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Clients Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">#</th>
                        <th class="py-3 px-6 text-left">First Name</th>
                        <th class="py-3 px-6 text-left">Last Name</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($clients as $client)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition ease-in-out duration-150">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $client->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $client->first_name }}</td>
                            <td class="py-3 px-6 text-left">{{ $client->last_name }}</td>
                            <td class="py-3 px-6 text-center">
                                <a href="{{ route('pages.client.show', $client->id) }}" class="text-blue-600 hover:text-blue-700 font-semibold">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                No clients found. Add a new client to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
