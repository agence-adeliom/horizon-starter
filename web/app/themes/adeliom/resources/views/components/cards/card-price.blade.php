<div>
  <p>{{ $title }}</p>
  <p>{{ $subtitle }}</p>
  <p>{{ $price }}</p>
  <p>{{ $subPrice }}</p>

  @if($button)
    <x-action.button :type="$button['type']" :label="$button['link']['title']" :url="$button['link']['url']"
                     :target="$button['link']['target']"
    />
  @endif

  @if($characteristics)
    @foreach($characteristics as $group)
      <div>
        @isset($group['title'])
          <p>{{ $group['title'] }}</p>
        @endisset

        @isset($group['items'])
          <ul>
            @foreach($group['items'] as $item)
              <li>{{ $item['title'] }}</li>
            @endforeach
          </ul>
        @endisset
      </div>
    @endforeach
  @endif
</div>
