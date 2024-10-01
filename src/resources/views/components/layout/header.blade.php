<header class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-semibold">Library Dashboard</h1>
    <div>
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 ml-2 bg-green-600 text-white rounded hover:bg-green-700">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</header>
