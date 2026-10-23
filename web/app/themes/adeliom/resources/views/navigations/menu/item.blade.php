@if ($item)
    @php
        $hasChildren = isset($item->hasChildren) && isset($item->children) && $item->hasChildren && $item->children;
        $submenuId = 'submenu-' . $item->id;
        $isOpen = "openSubmenus.includes({$item->id})";
        // An entry that opens a submenu is a button (its page stays reachable from the submenu link)
        $entryTag = $hasChildren ? 'button' : 'a';
    @endphp
    {{--  Desktop: disclosure, without focus trap. Mobile: full-screen panel, focus kept inside (x-trap) --}}
    <li @class($item->classes)
        @if ($hasChildren) :class="{{ $isOpen }} && 'is-active'"
            @keydown.escape="if ({{ $isOpen }}) { $event.stopPropagation(); closeSubMenu({{ $item->id }}, true) }"
            @focusout="isDesktop && $event.relatedTarget && !$el.contains($event.relatedTarget) && closeSubMenu({{ $item->id }})" @endif>

        <{{ $entryTag }} class="menu-item group"
            @if ($hasChildren) type="button" @click.stop="toggleSubMenu({{ $item->id }}, {{ $parent ? $parent->id : 'null' }})"
                aria-expanded="false" :aria-expanded="{{ $isOpen }}.toString()" aria-controls="{{ $submenuId }}"
            @else
                href="{{ $item->url }}" @endif>
            @if (isset($item->customFields['menu_item']['icon']) && $item->customFields['menu_item']['icon'])
                <x-ui.icon :icon="$item->customFields['menu_item']['icon']" class="icon-5" />
            @endif
            <span class="flex flex-col gap-1">
                <span class="menu-item-title group-hover:text-primary">
                    {{ $item->title }}
                    @if ($hasChildren && !$parent)
                        <x-far-angle-down class="icon-4 max-lg:-rotate-90" aria-hidden="true" />
                    @endif
                </span>
                @if (isset($item->description) && $item->description && $parent)
                    <x-typography.text :content="$item->description" class="menu-item-desc" />
                @endif
            </span>
            </{{ $entryTag }}>

            @if ($hasChildren)
                @include('navigations.menu.submenu', ['item' => $item, 'parent' => $parent])
            @endif
    </li>
@endif
