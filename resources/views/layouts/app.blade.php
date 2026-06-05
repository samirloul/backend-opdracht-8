<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Autorijschool De Komeet')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    @stack('styles')
</head>
<body>
    <div class="bg-shape bg-shape-left"></div>
    <div class="bg-shape bg-shape-right"></div>

    <header class="site-header">
        <div class="site-header-inner">
            <a class="brand" href="{{ route('home') }}">Autorijschool De Komeet</a>
            <nav class="main-nav">
                <a href="{{ route('instructors.index') }}" class="{{ request()->routeIs('instructors.*') ? 'active' : '' }}">Instructeurs in dienst</a>
                <a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">Alle voertuigen</a>
            </nav>
        </div>
    </header>

    <main class="page-wrap">
        @include('partials.flash')
        @yield('content')
    </main>

    <script src="{{ asset('js/flash-redirect.js') }}" defer></script>
</body>
</html>
