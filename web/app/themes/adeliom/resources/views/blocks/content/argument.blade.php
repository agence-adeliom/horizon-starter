<x-block :fields="$fields">
	<div class="flex flex-col items-start gap-6 p-3xlarge bg-primary rounded-xlarge  lg:justify-between lg:gap-7xlarge lg:p-6xlarge">
		<div class="flex flex-col gap-title-text-mobile lg:gap-title-text-desktop awc-theme-dark">
			@isset($fields['uptitle'])
				<x-typography.uptitle :content="$fields['uptitle']"/>
			@endisset
			
			@isset($fields['title'])
				<x-typography.heading :fields="$fields['title']" size="5"/>
			@endisset
			
			@isset($fields['args'])
				
				@foreach($fields['args'] as $arg)
					<div class="flex flex-col gap-2 dark">
                        <p class="font-semibold">{{$arg['arg_title']}}</p>
						<p>{{$arg['arg_desc']}}</p>
						
						@isset ($arg['arg_img'])
							<x-media.img :image="$arg['arg_img']" />
						@endisset
					</div>
				@endforeach
			@endisset
		</div>
		@isset($fields['button'])
			<x-action.button :fields="$fields['button']" type="tertiary" size="large"/>
		@endisset
	</div>
</x-block>