@extends('layout.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold mb-6">Books List</h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif


        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-wrap lg:flex-nowrap">
            <div class="w-full lg:w-3/4 p-4">
                <div id="books-list" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @forelse($books as $book)
                        <div class="{{ $book->client ? 'bg-red-100' : 'bg-gray-100' }} p-6 rounded-lg shadow-lg">
                            <h2 class="text-2xl font-semibold mb-4">{{ $book->title }}</h2>
                            <p><strong>Author:</strong> {{ $book->author }}</p>
                            <p><strong>Published:</strong> {{ $book->year_of_publication }}</p>
                            <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
                            @if($book->client)
                                <p><strong>Rented by:</strong> {{ $book->client->first_name }} {{ $book->client->last_name }}</p>
                            @endif
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
                            class="w-full p-2 border border-gray-300 rounded-lg @error('title') border-red-500 @enderror"
                        >
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="publisher" class="block text-sm font-medium text-gray-700">Search by Publisher</label>
                        <input
                            type="text"
                            id="publisher"
                            name="publisher"
                            value="{{ request('publisher') }}"
                            placeholder="Enter publisher..."
                            class="w-full p-2 border border-gray-300 rounded-lg @error('publisher') border-red-500 @enderror"
                        >
                        @error('publisher')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="author" class="block text-sm font-medium text-gray-700">Search by Author</label>
                        <input
                            type="text"
                            id="author"
                            name="author"
                            value="{{ request('author') }}"
                            placeholder="Enter author..."
                            class="w-full p-2 border border-gray-300 rounded-lg @error('author') border-red-500 @enderror"
                        >
                        @error('author')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="client" class="block text-sm font-medium text-gray-700">Search by Client Name</label>
                        <input
                            type="text"
                            id="client"
                            name="client"
                            value="{{ request('client') }}"
                            placeholder="Enter client name..."
                            class="w-full p-2 border border-gray-300 rounded-lg @error('client') border-red-500 @enderror"
                        >
                        @error('client')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
