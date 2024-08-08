<?php

namespace App\View\Components\Action;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    final public const TYPES = [
        'primary'   => 'btn--primary',
        'secondary' => 'btn--secondary',
        'tertiary'  => 'btn--tertiary',
    ];

    final public const SIZES = [
        'small'  => 'btn--small',
        'medium' => 'btn--medium',
        'large'  => 'btn--large',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $size = null,
        public ?string $type = null,
        public ?string $label = null,
        public ?string $url = null,
        public string  $target = "_self",
        public ?string $id = null,
        public ?string $tag = "div",
        public ?string $ariaLabel = null,
    )
    {
        $this->handleSize();
        $this->handleType();

    }

    private function handleSize(): void
    {
        $this->size = $this->size && in_array($this->size, self::SIZES) ? $this->size : null;
    }

    private function handleType(): void
    {
        $this->type = $this->type && in_array($this->type, self::TYPES) ? $this->type : null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action.button');
    }
}