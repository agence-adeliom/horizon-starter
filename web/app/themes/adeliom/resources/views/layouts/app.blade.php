<!doctype html>
<html @php(language_attributes())>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{--     Following link to change depending on project  --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    {{--    End   --}}

    @php(do_action('get_header'))
    @php(wp_head())
    @livewireStyles
</head>

<body @php(body_class())>
    @php(wp_body_open())

    <div id="app">
        <a class="sr-only focus:not-sr-only" href="#main">
            {{ __('Skip to content') }}
        </a>

        @if ($isLp)
            @include('sections.header-lp')
        @else
            @include('sections.header')
        @endif

        <main id="main" class="main">
            @yield('content')
        </main>

        @if ($isLp)
            @include('sections.footer-lp')
        @else
            @include('sections.footer')
        @endif
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())
    @livewireScripts
</body>

</html>
