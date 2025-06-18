@if ($primaryNavigation)
    <nav role="navigation" class="nav-primary max-lg:w-full" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
        <ul class="menu" x-data="initSubMenu" @click.away="closeAllSubmenu">
            @foreach ($primaryNavigation->items as $item)
                @include('navigations.menu.item', ['item' => $item, 'parent' => false])
            @endforeach
        </ul>
    </nav>
@endif
