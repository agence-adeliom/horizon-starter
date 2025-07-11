<div>
    @if(!$separateResultsByType)
        @if($typeChoices)
            @foreach($typeChoices as $typeSlug => $typeName)
                <label for="type_{{$typeSlug}}">{{$typeName}}</label>
                <input id="type_{{$typeSlug}}" type="radio" wire:model.live="typeChoice" value="{{$typeSlug}}"
                       @if($typeChoice === $typeSlug) checked="checked" @endif>
            @endforeach
        @endif
        @dump($results)
    @else
    @endif
</div>
