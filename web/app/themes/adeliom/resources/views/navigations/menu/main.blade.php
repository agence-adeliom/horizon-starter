@if ($primaryNavigation)

    <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
        <ul class="menu" x-data="initSubMenu">
            @foreach ($primaryNavigation->items as $item)
                @include('navigations.menu.item', ['item' => $item])
            @endforeach
        </ul>
    </nav>
@endif
