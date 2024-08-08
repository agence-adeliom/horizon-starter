<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Uptitle extends Component
{
    public ?string $fullClass = null;

    public function __construct(
        public string  $tag = 'div',
        public ?string $content = null,
        public ?string $class = null,
    )
    {
        $this->handleClasses();
    }

    private function handleClasses(): void
    {
        $this->fullClass = implode(' ', array_filter([
            'uptitle',
        ]));
    }

    public function render(): View|Closure|string
    {
        return view('components.uptitle');
    }
}
