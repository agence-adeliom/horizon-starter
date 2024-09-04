<div class="col-span-6 bg-full pt-24 relative rounded-card"
     style="background-image: url({{ $card['img']['sizes']['large'] ?? '' }})">
	<div class="absolute-full bg-linear rounded-card"></div>
	<div class="p-card flex flex-col items-start gap-card shadow-small-blur relative z-10">
		@isset($card['title'])
			<x-typography.heading :fields="$card['title']" :size="5" class="awc-theme-dark"/>
		@endisset
		@isset($card['wysiwyg'])
			<x-typography.text :content="$card['wysiwyg']" class=""/>
		@endisset
		@isset($card['button'])
			<x-action.button :object="$card['button']"/>
		@endisset
	</div>
</div>