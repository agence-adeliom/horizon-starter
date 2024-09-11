@php
	if(empty($fields['title']['content'])) {
		$fields['title']['content'] = get_the_title();
		$fields['title']['tag'] = 'h1';
	}
@endphp


<x-block :fields="$fields">
	<div class="grid-12">
		
		<div class="lg:col-span-5">
			
			<x-breadcrumbs/>
			
			@isset($fields['main_image']['sizes']['large'])
				<img src="{{ $fields['main_image']['sizes']['large'] }}" alt="">
			@endisset
		</div>
		
		<div class="lg:col-span-7">
			@isset($fields['uptitle'])
				<x-typography.uptitle :content="$fields['uptitle']"/>
			@endisset
			
			@isset($fields['title'])
				<x-typography.heading :fields="$fields['title']"/>
			@endisset
			
			@isset($fields['wysiwyg'])
				<div class="wysiwyg">
					{!! $fields['wysiwyg'] !!}
				</div>
			@endif
			
			@isset ($fields['buttons'])
				<x-action.buttons :buttons="$fields['buttons']"/>
			@endisset
		</div>
	</div>
</x-block>