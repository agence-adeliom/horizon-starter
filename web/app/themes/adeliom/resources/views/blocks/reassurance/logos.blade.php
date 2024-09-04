@if ($fields)
	<x-block :fields="$fields">
		@isset($fields['uptitle'])
			<x-typography.uptitle :content="$fields['uptitle']"/>
		@endisset
		
		@isset($fields['title'])
			<x-typography.heading :fields="$fields['title']"/>
		@endisset
		
		
		@isset($fields['logos'])
			<div class="flex flex-wrap justify-center items-center gap-medium">
				@foreach ($fields['logos'] as $logo)
					@php
						$logoImg = $logo['logo'] ?? null;
						$logoLink = $logo['link'] ?? null;
					@endphp
					
					@if (!empty($logoLink))
						<a href="{{ $logoLink['url'] }}" target="{{ $logoLink['target']}}">
							<img src="{{ $logoImg['url'] }}" alt="{{ $logoImg['alt'] }}" class="w-40"/>
						</a>
					@else
						<img src="{{ $logoImg['url'] }}" alt="{{ $logoImg['alt'] }}" class="w-40"/>
					@endif
				
				@endforeach
			</div>
		@endisset
	</x-block>
@endif