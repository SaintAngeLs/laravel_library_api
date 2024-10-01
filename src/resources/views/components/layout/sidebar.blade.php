<aside class="w-1/4 bg-gray-800 text-white">
    <div class="p-6">
        <h2 class="text-xl font-semibold">Library Navigation</h2>
        <nav class="mt-6">
            <ul>
                <li class="py-2">
                    <a href="{{ route('dashboard') }}"
                       class="{{ Route::is('dashboard') ? 'text-yellow-400' : 'text-white hover:text-gray-300' }}">
                        Dashboard
                    </a>
                </li>
                <li class="py-2">
                    <a href="{{ route('pages.book.index') }}"
                       class="{{ Route::is('pages.book.*') ? 'text-yellow-400' : 'text-white hover:text-gray-300' }}">
                        Books
                    </a>
                </li>
                <li class="py-2">
                    <a href="{{ route('pages.client.index') }}"
                       class="{{ Route::is('pages.client.*') ? 'text-yellow-400' : 'text-white hover:text-gray-300' }}">
                        Clients
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
