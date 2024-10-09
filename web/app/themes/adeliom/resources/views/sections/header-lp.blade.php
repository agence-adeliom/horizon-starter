@php
	//Gérer dans le CPT LP
	$btnHighlight = get_field('btn-highlight');
	$btnLp = !empty($btnHighlight['link']) ? $btnHighlight['link'] : null;
@endphp

<header class="banner bg-white b-bottom border-card py-4">
	<div class="container {{$btnLp ? 'flex justify-between items-center' : ''}}">
		@if ($logo)
			<a href="{{ home_url('/') }}" @class([
			    'flex justify-center',
			    'mx-auto' => ! $btnLp,
			])>
				<x-media.img :image="$logo" class="w-24 h-auto"/>
			</a>
		@endif

		@if ($btnLp)
        <x-action.button :fields="$btnHighlight" class="max-md:w-full"/>
		@endif
	</div>
</header>
