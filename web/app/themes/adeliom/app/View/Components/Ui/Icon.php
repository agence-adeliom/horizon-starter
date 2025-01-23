<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class Icon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public stdClass $icon,
        public ?string $class = '',
        public ?string $iconName = '',
    ) {
        $this->formatIconName($icon);
    }
    public function formatIconName($iconObject)
    {
        $prefix = match ($iconObject->style) {
            'regular' => 'far',
            'solid' => 'fas',
            'brands' => 'fab',
            default => 'fas',
        };

        $this->iconName = "{$prefix}-{$iconObject->id}";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.icon');
    }
}
