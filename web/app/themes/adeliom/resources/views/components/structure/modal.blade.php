<div x-data x-show="open" x-transition:enter="transition-opacity ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @keydown.escape.window="close()"
    class="fixed inset-0 w-full h-screen flex items-center justify-center z-[999] sm:p-4" style="display: none;">

    <div class="absolute inset-0 w-full h-full bg-black bg-opacity-50" @click="close()" aria-hidden="true">
    </div>

    <!-- Modal content -->
    <div x-show="open" x-transition:enter="transition-transform ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-20" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition-transform ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-20"
        x-trap.inert.noscroll="open" @class([
            'relative bg-white shadow-lg w-full max-w-3xl max-h-full overflow-hidden flex flex-col sm:max-h-[90%] sm:rounded-lg lg:max-h-[80%]',
            $attributes['class'],
        ])>

        <button type="button" @click="close()" class="absolute top-0 right-0 px-4 py-6 lg:p-6">
            <x-far-xmark class="icon-5 text-neutral-500" />
        </button>

        <!-- Header Slot -->
        @isset($header)
            <div @class(['px-4 py-6 lg:px-6', $header->attributes['class']])>
                {{ $header }}
            </div>
        @endisset

        <!-- Content Slot -->
        <div class="px-6 py-4 overflow-y-auto">
            {{ $slot }}
        </div>

        <!-- Footer Slot -->
        @isset($footer)
            <div @class([
                'px-4 py-6 border-t border-gray-300 lg:px-6',
                $footer->attributes['class'],
            ])>
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
