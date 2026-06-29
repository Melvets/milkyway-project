<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="img/icon1.png">

        <title>@yield('title', config('app.name') )</title>

        {{-- Bootstrap 5.3 --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display&display=swap" rel="stylesheet"/>

        {{-- Icon --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>

        <!-- Scripts -->
        <link rel="stylesheet" href="/css/dashboard.css?v={{ filemtime(public_path('css/dashboard.css')) }}">
    
    </head>
    <body>
        <div style="display:flex; min-height:100vh; width:100%;">
            @include('layout.dashboard.sidebar')

            {{-- Overlay for mobile sidebar --}}
            <div id="overlay"></div>

            <!-- Page Content -->
            <div id="main" style="flex:1; display:flex; flex-direction:column; min-height:100vh;">
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                @yield('container')
            </div>
        </div>

        {{-- Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        {{-- js --}}
        <script src="/js/dashboard.js?v={{ filemtime(public_path('js/dashboard.js')) }}"></script>
    </body>
</html>
