<div class="relative rounded-card bg-primary overflow-hidden">
	@isset($step['img'])
		<x-media.img :image="$step['img']" class="cover-full" size="medium"
		             container-class="aspect-[1.75] md:apect-[2] w-full"/>
	@endisset
	<div class="p-card flex flex-col items-start awc-theme-dark bg-primary z-10 relative">
		@isset($step['uptitle'])
			<x-typography.heading :content="$step['uptitle']" size="headline"/>
		@endisset
		
		@isset($step['title'])
			<x-typography.heading :content="$step['title']" size="5"/>
		@endisset
		
		@isset($step['content'])
			<x-typography.text :content="$step['content']" class=""/>
		@endisset
	</div>
</div>