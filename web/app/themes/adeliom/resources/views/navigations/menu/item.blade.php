@if ($item)
    @php $hasChildren = isset($item->hasChildren) && isset($item->children) && $item->hasChildren && $item->children; @endphp
    <li @class($item->classes)
        @if ($hasChildren) aria-haspopup="true"
        @click.prevent.stop="toggleSubMenu({{ $item->id }})"
        :aria-expanded="openSubmenus.includes({{ $item->id }})"
        :class="openSubmenus.includes({{ $item->id }}) && 'is-active'" @endif>

        <a class="menu-item group" href="{{ $item->url }}">
            @if (isset($item->customFields['menu_item']['icon']) && $item->customFields['menu_item']['icon'])
                <x-ui.icon :icon="$item->customFields['menu_item']['icon']" class="icon-5" />
            @endif
            <span class="flex flex-col gap-1">
                <span class="menu-item-title group-hover:text-primary">
                    {{ $item->title }}
                    @if ($hasChildren && !$parent)
                        <x-far-angle-down class="icon-4 max-lg:-rotate-90" />
                    @endif
                </span>
                @if (isset($item->description) && $item->description && $parent)
                    <x-typography.text :content="$item->description" class="menu-item-desc" />
                @endif
            </span>
        </a>

        @if ($hasChildren)
            <template x-teleport="#submenu-teleport">
                <div x-bind:aria-hidden="openSubmenus.includes({{ $item->id }})"
                    x-bind:aria-expanded="openSubmenus.includes({{ $item->id }})" data-mode="light" class="submenu"
                    :class="openSubmenus.includes({{ $item->id }}) && 'is-active'"
                    x-show="openSubmenus.includes({{ $item->id }})"
                    x-trap.inert.noscroll="openSubmenus.includes({{ $item->id }})"
                    x-transition:enter="ease-smooth duration-500" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-smooth duration-500"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                    <div class="submenu-container">
                        <span class="submenu-sidebar">
                            <div class="flex flex-col gap-y-medium">
                                @php
                                    $back_link_class =
                                        'cursor-pointer inline-flex font-semibold items-center gap-2 transition-colors duration-300 ease-in-out hover:text-primary lg:text-medium';
                                    $back_arrow_class = 'icon-4 grid place-items-center text-primary';
                                @endphp

                                @if (isset($item->parentId) && $item->parentId > 0 && $parent)
                                    <button class="{{ $back_link_class }}"
                                        @click.stop="toggleSubMenu({{ $parent->id }})">
                                        <x-fas-angle-left @class([$back_arrow_class]) />
                                        {{ $parent->submenu_back_label ?? __('Retour') }}
                                    </button>
                                @else
                                    <button class="{{ $back_link_class }} lg:hidden" @click="closeAllSubmenu">
                                        <x-fas-angle-left @class([$back_arrow_class]) />
                                        {{ __('Retour') }}
                                    </button>
                                @endif

                                <div class="flex flex-col gap-y-2x-small">

                                    <x-typography.text :content="$item->title" class="text-xlarge font-semibold" />

                                    @if (isset($item->description) && $item->description)
                                        <x-typography.text :content="$item->description" class="mt-1 text-small" />
                                    @endif
                                </div>
                            </div>

                            @if (isset($item->url) && $item->url && $item->url !== '#')
                                @php $button_label = isset($item->customFields['menu_item']['label']) && $item->customFields['menu_item']['label'] && $item->customFields['menu_item']['label'] !== '' ? $item->customFields['menu_item']['label'] : $item->title; @endphp
                                <x-action.button :url="$item->url"
                                    class="mt-4 lg:mt-6">{{ $button_label }}</x-action.button>
                            @endif
                        </span>

                        <ul class="submenu-list">

                            @foreach ($item->children as $subItem)
                                @include('navigations.menu.item', [
                                    'item' => $subItem,
                                    'parent' => $item,
                                ])
                            @endforeach
                        </ul>
                    </div>

                    <button @click="closeAllSubmenu" aria-label="Fermer le sous-menu"
                        class="max-lg:hidden absolute right-6 top-6 w-6 h-6 grid place-items-center cursor-pointer text-large lg:hover:text-primary transition-colors duration-300 ease-in-out">
                        <x-far-xmark class="icon-5 text-text-secondary" />
                    </button>
                </div>
            </template>
        @endif
    </li>
@endif
