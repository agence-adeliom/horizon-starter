@if ($item)
    <li @class($item->classes)><a href="{{ $item->url }}">{{ $item->title }}</a></li>
@endif
