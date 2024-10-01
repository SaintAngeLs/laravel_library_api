@extends('layout.app')

@section('content')
    <div class="container mx-auto my-12 max-w-4xl">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-6">{{ $book->title }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                    <p class="text-lg text-gray-700 mb-2"><strong>Author:</strong> {{ $book->author }}</p>
                    <p class="text-lg text-gray-700 mb-2"><strong>Published:</strong> {{ $book->year_of_publication }}</p>
                    <p class="text-lg text-gray-700 mb-2"><strong>Publisher:</strong> {{ $book->publisher }}</p>
                </div>
                <div class="flex flex-col justify-center">
                    @if($book->is_rented)
                        <p class="text-lg text-red-600 mb-4">
                            <strong>Status:</strong> This book is currently rented by
                            <span class="font-semibold">{{ $book->client->first_name }} {{ $book->client->last_name }}</span>.
                        </p>

                        <form action="{{ route('pages.book.return', $book->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-all duration-150">
                                Return Book
                            </button>
                        </form>
                    @else
                        <p class="text-lg text-green-600 mb-4">
                            <strong>Status:</strong> This book is available for rent.
                        </p>

                        <form action="{{ route('pages.book.rent', $book->id) }}" method="POST" class="mt-2">
                            @csrf
                            <div class="mb-4">
                                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Select Client</label>
                                <select name="client_id" id="client_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-all duration-150">
                                Rent Book
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('pages.book.index') }}" class="inline-block px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-all duration-150">
                    Back to Book List
                </a>
            </div>
        </div>
    </div>
@endsection
