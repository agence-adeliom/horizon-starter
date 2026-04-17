@if ($iconName && $canDisplay)
    @if ($ariaLabel)
        @svg($iconName, $class, ['role' => 'img', 'aria-label' => $ariaLabel])
    @else
        @svg($iconName, $class, ['aria-hidden' => 'true'])
    @endif
@endif
