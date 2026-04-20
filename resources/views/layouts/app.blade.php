<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    @php($isPomodoroPage = request()->routeIs('feature.pomodoro'))
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Nalarin.ai') }}</title>
        <link rel="icon" href="{{ asset('images/logo_nalarin_ai.png') }}" type="image/png">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:500,600,700,800" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .font-outfit { font-family: 'Outfit', sans-serif; }
            .font-inter { font-family: 'Inter', sans-serif; }
            .glass-panel {
                background: rgba(31, 41, 55, 0.7);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 3px; }
        </style>
    </head>
    <body class="font-inter antialiased bg-gray-950 text-gray-100 flex h-screen overflow-hidden selection:bg-purple-500/30">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col min-w-0 bg-gray-950/50 relative">
            <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-purple-900/10 to-transparent pointer-events-none -z-10"></div>

            <header class="md:hidden h-16 border-b border-white/5 glass-panel flex items-center justify-between px-4 z-20">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo_nalarin_ai.png') }}" class="w-8 h-8 object-contain" alt="Nalarin.ai Logo">
                </div>
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-300">Home</a>
            </header>

            @isset($header)
                <header class="{{ $isPomodoroPage ? 'py-3 px-4 md:px-5' : 'py-6 px-6 md:px-8' }} border-b border-white/5 glass-panel/50 flex-shrink-0">
                    <div class="max-w-6xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
                        {{ $header }}
                        @isset($headerActions)
                            <div>{{ $headerActions }}</div>
                        @endisset
                    </div>
                </header>
            @endisset

            <main class="flex-1 {{ $isPomodoroPage ? 'overflow-y-auto md:overflow-hidden p-2 md:p-3' : 'overflow-y-auto p-4 md:p-8' }}">
                <div class="max-w-6xl mx-auto h-full">{{ $slot }}</div>
            </main>
        </div>

        @auth
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const trackElements = document.querySelectorAll('.track-feature, [data-feature]');
                    trackElements.forEach(el => {
                        el.addEventListener('click', function() {
                            const featureName = this.getAttribute('data-feature');
                            if (!featureName) return;
                            fetch("{{ route('feature.track') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ feature_name: featureName })
                            }).catch(() => {});
                        });
                    });
                });
            </script>
        @endauth
    </body>
</html>
