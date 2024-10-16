<div>
  @isset($title)
    <p>{{ $title }}</p>
  @endisset

  @isset($subtitle)
    <p>{{ $subtitle }}</p>
  @endisset

  @isset($price)
    <p>{{ $price }}</p>
  @endisset

  @isset($subPrice)
    <p>{{ $subPrice }}</p>
  @endisset

  @if($button && isset($button['link']) && is_array($button['link']))
    <x-action.button :type="$button['type']" :label="$button['link']['title']" :url="$button['link']['url']"
                     :target="$button['link']['target']"
    />
  @endif

  @if($characteristics)
    @foreach($characteristics as $group)
      <div>
        @isset($group['title'])
          <p>
            <strong>{{ $group['title'] }}</strong>
          </p>
        @endisset

        @if(isset($group['items']) && $group['items'])
          <ul>
            @foreach($group['items'] as $item)
              <li>{{ $item['title'] }}</li>
            @endforeach
          </ul>
        @endif
      </div>
    @endforeach
  @endif
</div>
