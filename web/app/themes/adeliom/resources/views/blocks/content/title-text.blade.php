<x-block :fields="$fields">
	<div class="grid-12">
		<div class="lg:col-span-5">
			@isset($fields['uptitle'])
				<x-typography.uptitle :content="$fields['uptitle']"/>
			@endisset
			
			@isset($fields['title'])
				<x-typography.heading :fields="$fields['title']"/>
			@endisset
		</div>
		<div class="lg:col-span-7">
			@isset($fields['wysiwyg'])
				<x-typography.text :content="$fields['wysiwyg']" class=""/>
			@endisset
			
			@isset($fields['buttons'])
				<x-action.buttons :buttons="$fields['buttons']"/>
			@endisset
		
		</div>
	</div>
</x-block>