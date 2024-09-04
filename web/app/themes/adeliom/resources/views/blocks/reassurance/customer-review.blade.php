@if ($fields)
	<x-block :fields="$fields">
		@isset($fields['uptitle'])
			<x-typography.uptitle :content="$fields['uptitle']"/>
		@endisset
		
		@isset($fields['title'])
			<x-typography.heading :fields="$fields['title']"/>
		@endisset
		
		@isset($fields['wysiwyg'])
			<x-typography.text :content="$fields['wysiwyg']"/>
		@endisset
		
		@isset($context['global-rating'])
			@dump($context['global-rating'])
		@endisset
		
		@isset($context['btn-reviews'])
			<x-action.button :object="$context['btn-reviews']" class="w-full"/>
		@endisset
		
		<div class="lg:col-span-full">
			<div class="flex gap-6">
				@if (isset($fields['reviews']) && $fields['reviews'])
					@foreach ($fields['reviews'] as $review)
						@if (is_object($review) && property_exists($review, 'ID'))
							<x-cards.card-customer-review :review="get_fields($review->ID)"/>
						@endif
					@endforeach
				@endif
			</div>
		</div>
	</x-block>
@endif