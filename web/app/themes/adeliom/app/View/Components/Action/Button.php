<?php

namespace App\View\Components\Action;

use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    private ?string $typeClass = null;
    private ?string $sizeClass = null;
    public string $fullClass;

    final public const TYPES = [
        'primary'   => 'btn--primary',
        'secondary' => 'btn--secondary',
        'tertiary'  => 'btn--tertiary',
    ];

    final public const SIZES = [
        'small'  => 'btn--sm',
        'medium' => 'btn--md',
        'large'  => 'btn--lg',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $size = 'medium',
        public ?string $type = 'primary',
        public ?string $label = null,
        public ?string $url = null,
        public ?string $target = null,
        public ?string $id = null,
        public ?string $tag = "div",
        public ?string $ariaLabel = null,
        public ?array  $fields = null,
        public ?string $icon = null,
        public ?string $iconClass = null,
        public ?bool   $iconStart = false,
        public ?bool   $fullLink = false,
    ) {
        $this->handleType();
        $this->handleSize();
        $this->handleUrl();
        $this->handleTarget();
        $this->handleLabel();

        $this->handleFullClass();
    }

    private function handleType(): void
    {
        $type = null;

        if (null !== $this->type) {
            $type = $this->type && in_array($this->type, array_keys(self::TYPES)) ? $this->type : null;
        }


        if (null === $type) {
            if (null === $this->type && isset($this->fields[ButtonField::BUTTON_TYPE])) {
                $type = $this->fields[ButtonField::BUTTON_TYPE];
            }
        }

        if (null !== $type) {
            $this->type = $type;
            $this->typeClass = self::TYPES[$this->type];
        }
    }

    private function handleSize(): void
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

    private function handleUrl(): void
    {
        $url = null;

        if (null !== $this->url) {
            $url = $this->url;
        }

        if (null === $url && $this->fields && isset($this->fields[ButtonField::BUTTON_LINK]['url'])) {
            $url = $this->fields[ButtonField::BUTTON_LINK]['url'];
        }

        if ($url) {
            $this->url = $url;
            $this->tag = 'a';
        }
    }

    private function handleLabel(): void
    {
        $label = null;

        if (null !== $this->label) {
            $label = $this->label;
        }

        if (null === $label && $this->fields && isset($this->fields[ButtonField::BUTTON_LINK]['title'])) {
            $label = $this->fields[ButtonField::BUTTON_LINK]['title'];
        }

        if ($label) {
            $this->label = $label;
            $this->ariaLabel = $label;

            if ($this->target === '_blank') {
                $this->ariaLabel .= ' - Ouvrir dans un nouvel onglet';
            }
        }
    }

    private function handleTarget(): void
    {
        $target = null;

        if (null !== $this->target) {
            $target = $this->target;
        }

        if (null === $target && $this->fields && isset($this->fields[ButtonField::BUTTON_LINK]['target'])) {
            $target = $this->fields[ButtonField::BUTTON_LINK]['target'];
        }

        if ($target) {
            $this->target = $target;
        }
    }

    private function handleFullClass(): void
    {
        $this->fullClass = implode(' ', [
            'btn',
            $this->iconStart ? 'flex-row-reverse' : '',
            $this->typeClass,
            $this->sizeClass,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action.button');
    }
}
