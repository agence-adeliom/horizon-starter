@if($buttons)
  <div class="flex flex-col md:flex-row gap-4{{ $attributes['class'] ? ' '.$attributes['class'] : null }}">
    @foreach($buttons as $button)
      @if($loop->first)
        <x-action.button :object="$button" type="primary"/>
      @else
        <x-action.button :object="$button" type="secondary"/>
      @endif
    @endforeach
  </div>
@endif
