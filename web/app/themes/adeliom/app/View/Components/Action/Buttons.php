<?php

declare(strict_types=1);

namespace App\View\Components\Action;

use Adeliom\HorizonTools\Fields\Links\LinkField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Buttons extends Component
{
    public bool $isLinkFields;

    public function __construct(
        public array $buttons = [],
        public string $firstButtonType = 'primary',
        public ?string $firstButtonClass = null,
        public string $secondButtonType = 'secondary',
        public ?string $secondButtonClass = null,
        public ?string $baseClass = 'gap-4 flex flex-col md:flex-row',
    ) {
        $first = reset($this->buttons);
        $this->isLinkFields = is_array($first)
            && !empty($first[LinkField::FIELD_TYPE])
            && in_array($first[LinkField::FIELD_TYPE], [LinkField::VALUE_TYPE_INTERNAL, LinkField::VALUE_TYPE_EXTERNAL]);
    }

    public function render(): View|Closure|string
    {
        return view('components.action.buttons');
    }
}
