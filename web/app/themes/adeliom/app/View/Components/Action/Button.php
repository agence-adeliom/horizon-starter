<?php

declare(strict_types=1);

namespace App\View\Components\Action;

use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Links\LinkField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use InvalidArgumentException;

class Button extends Component
{
    final public const string ICON_ONLY = 'btn-icon-only';
    /**
     * Button hierarchy level
     * Adjust color and variant to your need
     **/
    final public const array TYPES = [
        'primary' => self::COLORS['tertiary'] . ' ' . self::VARIANTS['contain'],
        'secondary' => self::COLORS['primary'] . ' ' . self::VARIANTS['outline'],
        'tertiary' => self::COLORS['primary'] . ' ' . self::VARIANTS['text'],
    ];
    private const array COLORS = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'tertiary' => 'btn-tertiary',
    ];
    private const array VARIANTS = [
        'contain' => 'btn-contained',
        'outline' => 'btn-outlined',
        'text' => 'btn-text',
    ];
    final public const array SIZES = [
        'small' => 'btn-sm',
        'medium' => 'btn-md',
        'large' => 'btn-lg',
    ];
    public string $fullClass;
    private ?string $typeClass = null;
    private ?string $sizeClass = null;

    public function __construct(
        public ?string $size = 'large',
        public ?string $type = 'primary',
        public ?string $url = null,
        public ?string $label = null,
        public ?string $target = null,
        public ?string $tabindex = null,
        public ?string $title = null,
        public ?string $role = null,
        public ?string $id = null,
        public ?string $tag = 'div',
        public ?string $ariaLabel = null,
        public ?bool $iconOnly = false,
        public ?bool $fullLink = false,
        public ?bool $submit = null,
        // Only for fields button
        public ?array $fields = null,
        public null|string|object $icon = null,
        public ?string $iconClass = null,
        public ?bool $iconStart = false,
        public ?string $wireClick = null,
        public ?string $wireTarget = null,
        public bool $handleLivewireLoading = false,
        public bool $openAuthForm = false,
        public bool $openNewsletterForm = false,
        public bool $obfuscate = false,
        public ?string $atClick = null,
        public ?string $xShow = null,
        public ?array $link = null,
    ) {
        $this->handleAuthForm();
        $this->handleLink();
        $this->validateType($type);
        $this->validateSize($size);

        $this->handleType();
        $this->handleSize();
        $this->handleUrl();
        $this->handleTarget();
        $this->handleLabel();

        $this->handleFullClass();
    }

    private function handleAuthForm(): void
    {
        if ($this->openAuthForm || $this->openNewsletterForm) {
            if (!empty($this->wireClick)) {
                $this->wireTarget = null;
                $this->wireClick = null;
                $this->handleLivewireLoading = false;
            }
        }
    }

    private function handleLink(): void
    {
        if (empty($this->link[LinkField::FIELD_TYPE])) {
            return;
        }

        $this->icon = !empty($this->link[LinkField::FIELD_ICON]) ? $this->link[LinkField::FIELD_ICON] : null;
        $this->obfuscate = !empty($this->link[LinkField::FIELD_OBFUSCATE]) && $this->link[LinkField::FIELD_OBFUSCATE];

        switch ($this->link[LinkField::FIELD_TYPE]) {
            case LinkField::VALUE_TYPE_EXTERNAL:
                $this->url = !empty($this->link[LinkField::FIELD_LINK]['url']) ? $this->link[LinkField::FIELD_LINK]['url'] : null;
                $this->label = !empty($this->link[LinkField::FIELD_LINK]['title']) ? $this->link[LinkField::FIELD_LINK]['title'] : null;
                $this->target = !empty($this->link[LinkField::FIELD_LINK]['target']) ? $this->link[LinkField::FIELD_LINK]['target'] : null;
                $this->obfuscate =
                    !empty($this->link[LinkField::FIELD_LINK]['obfuscate']) && $this->link[LinkField::FIELD_LINK]['obfuscate'] == 1;
                break;
            case LinkField::VALUE_TYPE_INTERNAL:
                $this->url = !empty($this->link[LinkField::FIELD_POST]) ? get_permalink($this->link[LinkField::FIELD_POST]) : null;
                $this->label = !empty($this->link[LinkField::FIELD_POST_LABEL])
                    ? $this->link[LinkField::FIELD_POST_LABEL]
                    : (!empty($this->link[LinkField::FIELD_POST])
                        ? get_the_title($this->link[LinkField::FIELD_POST])
                        : null);
                $this->target =
                    !empty($this->link[LinkField::FIELD_IS_TARGET_BLANK]) && $this->link[LinkField::FIELD_IS_TARGET_BLANK]
                        ? '_blank'
                        : null;
                break;
        }
    }

    private function validateType(?string $type): void
    {
        if ($type !== null && !in_array($type, array_keys(self::TYPES))) {
            throw new InvalidArgumentException(
                "Invalid button type: '{$type}'. Allowed types are: " . implode(', ', array_keys(self::TYPES)) . '.',
            );
        }
    }

    private function validateSize(?string $size): void
    {
        if ($size !== null && !in_array($size, array_keys(self::SIZES))) {
            throw new InvalidArgumentException(
                "Invalid button size: '{$size}'. Allowed sizes are: " . implode(', ', array_keys(self::SIZES)) . '.',
            );
        }
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

        if ($this->type === 'none') {
            return;
        }

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

    private function handleFullClass(): void
    {
        $this->fullClass = implode(
            ' ',
            array_filter([
                'none' !== $this->type ? 'btn' : null,
                $this->iconStart ? 'flex-row-reverse' : '',
                $this->fullLink ? 'static' : '',
                $this->typeClass,
                $this->sizeClass,
                $this->iconOnly ? self::ICON_ONLY : '',
            ]),
        );
    }

    public function render(): View|Closure|string
    {
        return view('components.action.button');
    }
}
