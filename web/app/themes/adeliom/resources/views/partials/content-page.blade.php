@php(the_content())

@if ($pagination)
    <nav role="navigation" class="page-nav" aria-label="Page">
        {!! $pagination !!}
    </nav>
@endif
