@php
    //Gérer dans le CPT LP
    $btnHighlight = get_field('btn-highlight');
    $btnLp = !empty($btnHighlight['link']) ? $btnHighlight['link'] : null;
@endphp

<header class="banner b-bottom border-card bg-white py-4">
    <div class="{{ $btnLp ? 'flex justify-between items-center' : '' }} container">
        @if ($logo)
            <x-media.img :image="$logo" class="mx-auto h-auto w-24" />
        @endif

        @if ($btnLp)
            <x-action.button :fields="$btnHighlight" class="max-md:w-full" />
        @endif
    </div>
</header>
