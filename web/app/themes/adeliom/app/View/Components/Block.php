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
        'primary'       => 'bg-primary',
    ];

    final public const PADDINGS = [
        'none'  => 'py-0 lg:py-0',
        'small' => 'py-large',
        'large' => 'py-section-mobile lg:py-section-desktop',
    ];

    final public const TOP_PADDINGS = [
        'none'  => 'pt-0 lg:pt-0',
        'small' => 'pt-large',
        'large' => 'pt-section-mobile lg:pt-section-desktop',
    ];

    final public const BOTTOM_PADDINGS = [
        'none'  => 'pb-0 lg:pb-0',
        'small' => 'pb-large',
        'large' => 'pb-section-mobile lg:pb-section-desktop',
    ];

    final public const CONTAINERS = [
        'inital' => 'container',
        'fluid'  => 'max-w-[1400px] m-auto px-20',
    ];

    final public const BACKGROUND_TYPES = [
        'none'  => '',
        'color' => 'bg_color',
        'image' => 'bg_image',
    ];

    public ?string $baseClass = 'relative';
    public ?string $backgroundClass = null;
    public ?string $paddingClass = null;
    public ?string $containerClass = null;
    public ?string $darkModeClass = null;
    public ?string $freeClass = null;
    public ?array $bgImage = null;

    public ?string $fullClass = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public null|false|array $fields = [],
        public ?string          $background = null,
        public ?string          $padding = null, // 'none', 'small', 'large'
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


    private function handleClassName(): void
    {
        if (null === $this->class) {
            $this->freeClass = '';
        } else {
            $this->freeClass = $this->class;
        }
    }

    private function handleBackground(): void
    {
        if (isset($this->fields[LayoutField::FIELD_BG_GROUP])) {
            $bgType = $this->fields[LayoutField::FIELD_BG_GROUP][LayoutField::FIELD_BG_TYPE] ?? 'none';

            if ($bgType === self::BACKGROUND_TYPES['none']) {
                $this->background = 'none';
            } else if ($bgType === self::BACKGROUND_TYPES['color']) {
                $this->background = 'none';
                $this->backgroundClass = $this->fields[LayoutField::FIELD_BG_GROUP][LayoutField::FIELD_BG_COLOR];
            } else if ($bgType === self::BACKGROUND_TYPES['image'] && isset($this->fields[LayoutField::FIELD_BG_GROUP][LayoutField::FIELD_BG_IMAGE])) {
                $this->background = 'none';
                $this->containerClass = 'relative z-10';
                $this->bgImage = $this->fields[LayoutField::FIELD_BG_GROUP][LayoutField::FIELD_BG_IMAGE];


            }
        } else if (null === $this->background || !in_array($this->background, array_keys(self::BACKGROUNDS))) {
            $this->background = 'white';
        } else if (isset(self::BACKGROUNDS[$this->background])) {
            $this->backgroundClass = self::BACKGROUNDS[$this->background];
        }

    }

    private function handlePaddings(): void
    {
        $marginTopSizeField = $this->fields[LayoutField::FIELD_MARGIN][LayoutField::FIELD_MARGIN_TOP_SIZE] ?? null;
        $marginBottomSizeField = $this->fields[LayoutField::FIELD_MARGIN][LayoutField::FIELD_MARGIN_BOTTOM_SIZE] ?? null;

        // if padding is not set or not in the list of paddings, set it to large
        if (null === $this->padding || !in_array($this->padding, array_keys(self::PADDINGS))) {
            $this->padding = 'large';
        }

        // if padding is in blade component
        if (isset(self::PADDINGS[$this->padding])) {
            $this->paddingClass = self::PADDINGS[$this->padding];
        }

        // if top padding is set in the fields, use it
        if (isset($marginTopSizeField) && isset(self::TOP_PADDINGS[$marginTopSizeField]) && $this->padding !== 'none') {
            $this->paddingClass = self::TOP_PADDINGS[$marginTopSizeField];
        }

        // if bottom padding is set in the fields, use it
        if (isset($marginBottomSizeField) && isset(self::BOTTOM_PADDINGS[$marginBottomSizeField]) && $this->padding !== 'none') {
            $this->paddingClass .= ' ' . self::BOTTOM_PADDINGS[$marginBottomSizeField];
        }
    }


    private function handleContainer(): void
    {
        if (null === $this->container || !in_array($this->container, array_keys(self::CONTAINERS))) {
            $this->container = 'inital';
        }

        if (isset(self::CONTAINERS[$this->container])) {
            $this->containerClass .= ' ' . self::CONTAINERS[$this->container];
        }
    }

    private function handleDarkmode(): void
    {
        if (isset($this->fields[LayoutField::FIELD_DARK_MODE]) && $this->fields[LayoutField::FIELD_DARK_MODE]) {
            $this->darkModeClass = "dark awc-theme-dark";
        }
    }

    private function handleFullClass(): void
    {
        $this->fullClass = implode(' ', [
            $this->baseClass,
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