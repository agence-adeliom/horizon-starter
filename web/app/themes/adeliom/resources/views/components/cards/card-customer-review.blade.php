<div class="relative rounded-card bg-primary overflow-hidden">
	
	@php
		$reviewInfo = $review['review'] ?? null;
        $reviewer = $review['reviewer'] ?? null;
	@endphp
	
	@isset($reviewInfo['rating'])
		@dump($reviewInfo['rating'])
	@endisset
	
	@isset($reviewInfo['review'])
		<p>{{$reviewInfo['review']}}</p>
	@endisset
	
	<div class="flex">
		@if(@isset($reviewer['avatar']) && $reviewer['avatar'] !== false)
			<x-media.img :image="$reviewer['avatar']" class="rounded-full w-20" size="small"/>
		@else
			<div class="rounded-full bg-primary-light">
				{{ substr($reviewer['firstname'], 0, 1) }}{{ substr($reviewer['lastname'], 0, 1) }}
			</div>
		@endif
		<div>
			@isset($reviewer['firstname'])
				<p>{{$reviewer['firstname']}}</p>
			@endisset
			@isset($reviewer['lastname'])
				<p>{{$reviewer['lastname']}}</p>
			@endisset
			@isset($reviewer['job'])
				<p>{{$reviewer['job']}}</p>
			@endisset
		</div>
	</div>

</div>