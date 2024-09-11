@php
	//Gérer dans le CPT LP
	$btnHighlight = get_field('btn-highlight');
	$btnLp = !empty($btnHighlight['link']) ? $btnHighlight['link'] : null;
@endphp
<footer class="footer-lp bg-primary py-section-mobile lg:py-section-desktop">
	<div class="container awc-theme-dark flex flex-col">
		<div class="border-b border-primary-light w-full pb-8 md:pb-5xlarge {{$btnLp ? 'flex justify-between items-center' : ''}}">
			@if ($logoFooter)
				<a href="{{ home_url('/') }}" class="{{!$btnLp ? 'mx-auto': ''}} flex justify-center">
					<x-media.img :image="$logoFooter" class="max-w-xs" size="medium"/>
				</a>
			@endif
			
			@if ($btnLp)
				<x-action.button :object="$btnHighlight" class="max-md:w-full"/>
			@endif
		</div>
		@include('sections.footer-bottom')
	</div>
</footer>