<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir Ende')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; padding: 12px 20px; background-color: #f3f4f6; border-bottom: 1px solid #d1d5db; margin-bottom: 20px;">
        <div>
            <strong>Kasir Ende</strong>
            @auth
                @if(auth()->user()->role === 'pemilik')
                    | <a href="/dashboard-pemilik">Dashboard Pemilik</a>
                    | <a href="/katalog">Katalog</a>
                @endif
            @endauth
        </div>

        @auth
            <div style="display: flex; align-items: center; gap: 12px;">
                <span>
                    Halo, <strong>{{ auth()->user()->name }}</strong> 
                    ({{ ucfirst(auth()->user()->role) }})
                </span>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="padding: 6px 12px; cursor: pointer;">Logout</button>
                </form>
            </div>
        @endauth
    </header>

    <main style="padding: 0 20px;">
        @yield('content')
    </main>
</body>
</html>
