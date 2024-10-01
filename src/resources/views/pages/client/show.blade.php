@extends('layout.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold mb-6">{{ $client->first_name }} {{ $client->last_name }}</h1>

        <a href="{{ route('pages.client.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Clients</a>

        <form action="{{ route('pages.client.destroy', $client->id) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete Client</button>
        </form>
    </div>
@endsection
