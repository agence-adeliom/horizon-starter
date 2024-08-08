@if($buttons)
  <div class="flex flex-col md:flex-row gap-4{{ $attributes['class'] ? ' '.$attributes['class'] : null }}">
    @foreach($buttons as $button)
      <x-action.button :object="$button"/>
    @endforeach
  </div>
@endif
