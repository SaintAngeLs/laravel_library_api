@extends('layout.app')

@section('content')
    <div class="container">
        <h1 class="text-3xl font-semibold mb-6">{{ $book->title }}</h1>

        <p><strong>Author:</strong> {{ $book->author }}</p>
        <p><strong>Published:</strong> {{ $book->year_of_publication }}</p>
        <p><strong>Publisher:</strong> {{ $book->publisher }}</p>

        @if($book->is_rented)
            <p class="text-red-500">This book is currently rented by {{ $book->client->first_name }} {{ $book->client->last_name }}.</p>

            <form action="{{ route('pages.book.return', $book->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Return Book
                </button>
            </form>

        @else
            <p class="text-green-500">This book is available for rent.</p>

            <form action="{{ route('pages.book.rent', $book->id) }}" method="POST" class="mt-4">
                @csrf

                <label for="client_id" class="block text-sm font-medium text-gray-700">Select Client</label>
                <select name="client_id" id="client_id" class="w-full p-2 border border-gray-300 rounded-lg mb-4" required>
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Rent Book
                </button>
            </form>
        @endif

        <a href="{{ route('pages.book.index') }}" class="mt-4 inline-block bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">Back to List</a>
    </div>
@endsection
