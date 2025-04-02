@if (! empty($fields['uptitle']))
  <x-typography.uptitle :content="$fields['uptitle']"/>
@endif

@if (! empty($fields['title']))
  <x-typography.heading :fields="$fields['title']"/>
@endif

<div>
  <div>
    @if (! empty($context['mainPosts']))
      @dump($context['mainPosts'])
    @endif
  </div>

  <div>
    @if (! empty($context['posts']))
      @dump($context['posts'])
    @endif
  </div>
</div>

@if (! empty($fields['buttons']))
  <x-action.buttons :buttons="$fields['buttons']"/>
@endif
