<?php

namespace App\View\Components\Typography;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    private ?string $sizeClass = null;
    private ?string $variantClass = null;
    public string $fullClass;

    final public const SIZES = [
        'xs'   => 'text-xs',
        'sm'   => 'text-sm',
        'md'   => 'text-md',
        'lg'   => 'text-lg',
        'xl'   => 'text-xl',
    ];

    final public const VARIANTS = [
        'solid'   => 'fas',
        'regular'   => 'far',
        'light'   => 'fal',
        'thin'   => 'fat',
        'duotone'   => 'fad',
        'brand'   => 'fab',
        'kit'   => 'fak',
    ];
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $size = 'md',
        public string $variant = 'regular',
        public string $icon = '',
        public ?string $class = null,
    ) {
        $this->handleType();
        $this->handleVariant();

        $this->handleFullClass();
    }

    private function handleType(): void
    {
        $size = null;

        if (null !== $this->size) {
            $size = $this->size && in_array($this->size, array_keys(self::SIZES)) ? $this->size : null;
        }

        if (null !== $size) {
            $this->size = $size;
            $this->sizeClass = self::SIZES[$this->size];
        }
    }
    private function handleVariant(): void
    {
        $variant = null;

        if (null !== $this->variant) {
            $variant = $this->variant && in_array($this->variant, array_keys(self::VARIANTS)) ? $this->variant : null;
        }

        if (null !== $variant) {
            $this->variant = $variant;
            $this->variantClass = self::VARIANTS[$this->variant];
        }
    }

    private function handleFullClass(): void
    {
        $this->fullClass = implode(' ', [
            'fa-fw',
            'fa-' . $this->icon,
            $this->variantClass,
            $this->sizeClass,
            $this->class ?? '',
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.typography.icon');
    }
}
