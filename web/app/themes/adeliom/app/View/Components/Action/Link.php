<?php

declare(strict_types=1);

namespace App\View\Components\Action;

use App\Fields\Links\LinkField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public ?string $label = null;
    public ?string $url = null;
    public ?string $target = null;
    public null|string|object $icon = null;

    public function __construct(public readonly ?array $link = null)
    {
        if (!empty($this->link[LinkField::FIELD_TYPE])) {
            $this->icon = !empty($this->link[LinkField::FIELD_ICON]) ? $this->link[LinkField::FIELD_ICON] : null;

            switch ($this->link[LinkField::FIELD_TYPE]) {
                case LinkField::VALUE_TYPE_EXTERNAL:
                    $this->url = !empty($this->link[LinkField::FIELD_LINK]['url']) ? $this->link[LinkField::FIELD_LINK]['url'] : null;
                    $this->label = !empty($this->link[LinkField::FIELD_LINK]['title']) ? $this->link[LinkField::FIELD_LINK]['title'] : null;
                    $this->target = !empty($this->link[LinkField::FIELD_LINK]['target'])
                        ? $this->link[LinkField::FIELD_LINK]['target']
                        : null;
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
                default:
                    break;
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.action.link');
    }
}
