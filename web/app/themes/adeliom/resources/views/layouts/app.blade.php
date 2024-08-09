<!doctype html>
<html @php(language_attributes())>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    @if($isLp)
        @include('sections.header-lp')
    @else
        @include('sections.header')
    @endif

    <main id="main" class="main">
        @yield('content')
    </main>

    @if($isLp)
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