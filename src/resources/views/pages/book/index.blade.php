@extends('layout.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold mb-6">Books List</h1>

        <div class="flex flex-wrap lg:flex-nowrap">

            <div class="w-full lg:w-3/4 p-4">
                <div id="books-list" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @forelse($books as $book)
                        <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                            <h2 class="text-2xl font-semibold mb-4">{{ $book->title }}</h2>
                            <p><strong>Author:</strong> {{ $book->author }}</p>
                            <p><strong>Published:</strong> {{ $book->year_of_publication }}</p>
                            <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
                            <a href="{{ route('pages.book.show', $book->id) }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                View Details
                            </a>
                        </div>
                    @empty
                        <p>No books found.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $books->appends(request()->input())->links('vendor.pagination.tailwind') }}
                </div>
            </div>

            <div class="w-full lg:w-1/4 p-4 bg-white rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-4">Search Books</h2>

                <form id="search-form" action="{{ route('pages.book.index') }}" method="GET">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Search by Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ request('title') }}"
                            placeholder="Enter title..."
                            class="w-full p-2 border border-gray-300 rounded-lg"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="publisher" class="block text-sm font-medium text-gray-700">Search by Publisher</label>
                        <input
                            type="text"
                            id="publisher"
                            name="publisher"
                            value="{{ request('publisher') }}"
                            placeholder="Enter publisher..."
                            class="w-full p-2 border border-gray-300 rounded-lg"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="author" class="block text-sm font-medium text-gray-700">Search by Author</label>
                        <input
                            type="text"
                            id="author"
                            name="author"
                            value="{{ request('author') }}"
                            placeholder="Enter author..."
                            class="w-full p-2 border border-gray-300 rounded-lg"
                        >
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
