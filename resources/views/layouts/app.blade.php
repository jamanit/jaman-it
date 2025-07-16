<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {!! $settingItems['meta']->value ?? '' !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@stack('title', 'Page') - {{ $settingItems['site_name']->value ?? 'Site Name' }}</title>

    @if ($settingItems['favicon']->value && Storage::disk('public')->exists($settingItems['favicon']->value))
        <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url($settingItems['favicon']->value) }}" rel="shortcut icon">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}assets/images/favicon.png">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet" />

    <script>
        function navbarScroll() {
            return {
                scrolled: false,
                init() {
                    this.checkScroll();
                    window.addEventListener("scroll", () => this.checkScroll());
                },
                checkScroll() {
                    this.scrolled = window.scrollY > 10;
                },
            };
        }
    </script>

    <script defer src="{{ asset('/') }}assets/alpinejs/alpinejs@3.x.x-cdn.min.js"></script>

    @stack('styles')
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-inter min-h-screen flex flex-col bg-slate-950 text-white" x-data="{ showScroll: false, postModal: false, post: {}, serviceModal: false }" x-init="window.addEventListener('scroll', () => { showScroll = window.pageYOffset > 100; })">
    @include('layouts.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('services.service-modal')

    @include('layouts.footer')

    @include('layouts.scroll-to-top')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>
