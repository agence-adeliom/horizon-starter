<?php

namespace App\View\Components;

use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Block extends Component
{
    final public const BACKGROUNDS = [
        'none'          => '',
        'white'         => 'bg-white',
        'black'         => 'bg-neutral-1000',
        'basic-neutral' => 'bg-neutral-50',
    ];

    final public const PADDINGS = [
        'none'          => '',
        'small'         => 'py-10',
        'large'         => 'py-10 lg:py-20',
        'top-remove'    => 'pt-0 lg:pt-0',
        'bottom-remove' => 'pb-0 lg:pb-0',
    ];

    final public const CONTAINERS = [
        'inital' => 'container',
        'fluid'  => 'max-w-[1400px] m-auto px-20',
    ];

    public ?string $backgroundClass = null;
    public ?string $paddingClass = null;
    public ?string $containerClass = null;
    public ?string $darkModeClass = null;
    public ?string $freeClass = null;

    public ?string $fullClass = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public null|false|array $fields = [],
        public ?string          $background = null,
        public ?string          $padding = null,
        public ?string          $container = null,
        public ?string          $anchor = null,
        public ?string          $class = null,
    )
    {

        $this->handleClassName();
        $this->handleBackground();
        $this->handlePaddings();
        $this->handleContainer();
        $this->handleDarkmode();
        $this->handleFullClass();
    }


    private function handleClassName() :void {
        if (null === $this->class) {
            $this->freeClass = '';
        } else {
            $this->freeClass = $this->class;
        }
    }
    private function handleBackground(): void
    {
        if (null === $this->background || !in_array($this->background, array_keys(self::BACKGROUNDS))) {
            $this->background = 'white';
        }

        if (isset(self::BACKGROUNDS[$this->background])) {
            $this->backgroundClass = self::BACKGROUNDS[$this->background];
        }
    }

    private function handlePaddings(): void
    {
        $marginSizesField = $this->fields[LayoutField::MARGIN][LayoutField::MARGIN_SIZES];
        $removeMarginTopField = $this->fields[LayoutField::MARGIN][LayoutField::MARGIN_TOP_REMOVE];
        $removeMarginBottomField = $this->fields[LayoutField::MARGIN][LayoutField::MARGIN_BOTTOM_REMOVE];

        // if padding is not set or not in the list of paddings, set it to large
        if (null === $this->padding || !in_array($this->padding, array_keys(self::PADDINGS))) {
            $this->padding = 'large';
        }

        // if padding is in blade component
        if (isset(self::PADDINGS[$this->padding])) {
            $this->paddingClass = self::PADDINGS[$this->padding];
        }

        // if padding is set in the fields, use it
        if (isset($marginSizesField)) {
            $this->paddingClass = self::PADDINGS[$marginSizesField];
        }

        // if remove top margin or remove bottom margin is set
        if (isset($removeMarginTopField) && $removeMarginTopField) {
            $this->paddingClass .= ' ' . self::PADDINGS["top-remove"];
        }

        if (isset($removeMarginBottomField) && $removeMarginBottomField) {
            $this->paddingClass .= ' ' . self::PADDINGS["bottom-remove"];
        }
    }


    private function handleContainer(): void
    {
        if (null === $this->container || !in_array($this->container, array_keys(self::CONTAINERS))) {
            $this->container = 'inital';
        }

        if (isset(self::CONTAINERS[$this->container])) {
            $this->containerClass = self::CONTAINERS[$this->container];
        }
    }

    private function handleDarkmode(): void
    {
        if (isset($this->fields[LayoutField::DARK_MODE]) && $this->fields[LayoutField::DARK_MODE]) {
            $this->darkModeClass = "dark";
        }
    }

    private function handleAnchor(): void
    {

    }

    private function handleFullClass(): void
    {
        $this->fullClass = implode(' ', [
            $this->freeClass,
            $this->backgroundClass,
            $this->paddingClass,
            $this->darkModeClass,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.block');
    }
}