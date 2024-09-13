@if ($item)
    @php $hasChildren = isset($item->hasChildren) && isset($item->children) && $item->hasChildren && $item->children; @endphp
    <li @class($item->classes)
        @if ($hasChildren) aria-haspopup="true"
        @click.prevent.stop="toggleSubMenu({{ $item->id }})"
        :class="openSubmenus.includes({{ $item->id }}) && 'is-active'" @endif>

        <a class="menu-item group" href="{{ $item->url }}">
            @if (isset($item->customFields['menu_item']['icon']) && $item->customFields['menu_item']['icon'])
                {!! $item->customFields['menu_item']['icon'] !!}
            @endif
            <span class="flex flex-col gap-1">
                <span class="menu-item__title group-hover:text-primary">
                    {{ $item->title }}
                    @if ($hasChildren && !$parent)
                        <x-typography.icon class="max-lg:-rotate-90" size="sm" icon="angle-down" />
                    @endif
                </span>
                @if (isset($item->description) && $item->description && $parent)
                    <x-typography.text :content="$item->description" class="menu-item__desc" />
                @endif
            </span>
        </a>

        @if ($hasChildren)
            <template x-teleport="#submenu-teleport">
                <div aria-expanded="false" :aria-expanded="openSubmenus.includes({{ $item->id }})" data-mode="light"
                    class="submenu" :class="openSubmenus.includes({{ $item->id }}) && 'is-active'"
                    x-show="openSubmenus.includes({{ $item->id }})" x-transition:enter="ease-smooth duration-500"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-smooth duration-500" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <div class="submenu__container">
                        <span class="submenu__sidebar">
                            <div class="flex flex-col gap-y-medium">
                                @php
                                    $back_link_class =
                                        'cursor-pointer inline-flex font-semibold items-center gap-2 transition-colors duration-300 ease-in-out hover:text-primary lg:text-medium';
                                    $back_arrow_class =
                                        'px-x-small w-3.5 h-3.5 grid place-items-center text-x-small text-primary';
                                @endphp

                                @if (isset($item->parentId) && $item->parentId > 0 && $parent)
                                    <button class="{{ $back_link_class }}"
                                        @click.stop="toggleSubMenu({{ $parent->id }})">
                                        <x-typography.icon @class($back_arrow_class) icon="angle-left" />
                                        {{ $parent->submenu_back_label ?? __('Retour') }}
                                    </button>
                                @else
                                    <button class="{{ $back_link_class }} lg:hidden" @click="closeAllSubmenu">
                                        <x-typography.icon @class($back_arrow_class) icon="angle-left" />
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
                                <x-action.button :label="$button_label" :url="$item->url" class="mt-4 lg:mt-6" />
                            @endif
                        </span>

                        <ul class="submenu__list">

                            @foreach ($item->children as $subItem)
                                @include('navigations.menu.item', [
                                    'item' => $subItem,
                                    'parent' => $item,
                                ])
                            @endforeach
                        </ul>
                    </div>

                    <span @click="closeAllSubmenu"
                        class="max-lg:hidden absolute right-6 top-6 w-6 h-6 grid place-items-center cursor-pointer text-large lg:hover:text-primary transition-colors duration-300 ease-in-out">
                        <x-typography.icon icon="xmark" />

                    </span>
                </div>
            </template>
        @endif
    </li>
@endif
