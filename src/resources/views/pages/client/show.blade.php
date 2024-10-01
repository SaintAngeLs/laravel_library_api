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

        <h2 class="text-2xl font-semibold mt-6">Rented Books</h2>
        <div class="mt-4">
            @if($rentedBooks->isEmpty())
                <p>This client has not rented any books.</p>
            @else
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Title</th>
                            <th class="px-4 py-2 border">Author</th>
                            <th class="px-4 py-2 border">Year of Publication</th>
                            <th class="px-4 py-2 border">Publisher</th>
                            <th class="px-4 py-2 border">Return Book</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentedBooks as $book)
                            <tr>
                                <td class="px-4 py-2 border">{{ $book->title }}</td>
                                <td class="px-4 py-2 border">{{ $book->author }}</td>
                                <td class="px-4 py-2 border">{{ $book->year_of_publication }}</td>
                                <td class="px-4 py-2 border">{{ $book->publisher }}</td>
                                <td class="px-4 py-2 border">
                                    <form action="{{ route('pages.book.return', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                            Return
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
