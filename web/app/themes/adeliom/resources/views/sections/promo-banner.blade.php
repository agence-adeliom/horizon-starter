@if($isActive)
	<section class="promo-banner bg-primary p-medium relative flex items-center justify-center"
	         x-data="{ isHidden: document.cookie.includes('promo_banner_hidden=true') }"
	         x-init="if (isHidden) $el.remove()">
		<div class="flex gap-title-text-desktop justify-center items-center awc-theme-dark flex-grow">
			@isset($bannerTitle)
				<x-typography.text :content="$bannerTitle"/>
			@endisset
			
			@isset($bannerLink)
				<a href="{{ $bannerLink['url'] }}" target="{{ $bannerLink['target'] }}"
				   class="link text-small">{{ $bannerLink['title'] }}</a>
			@endisset
		</div>
		
		<x-typography.icon icon="xmark" class="text-lg transition-all hover:opacity-40 cursor-pointer"
		                   @click="document.cookie = 'promo_banner_hidden=true; path=/'; $el.closest('section').remove()"/>
		
		<div @click="document.cookie = 'promo_banner_hidden=true; path=/'; $el.closest('section').remove()">
		</div>
	</section>
@endif