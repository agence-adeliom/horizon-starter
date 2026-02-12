<?php

declare(strict_types=1);

namespace App\View\Components\Action;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Buttons extends Component
{
    public function __construct(
        public array $buttons = [],
        public string $firstButtonType = 'primary',
        public ?string $firstButtonClass = null,
        public string $secondButtonType = 'secondary',
        public ?string $secondButtonClass = null,
        public ?string $baseClass = 'gap-4 flex flex-col md:flex-row',
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.action.buttons');
    }
}
