<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public ?string $content = null;

    public function __construct()
    {
        $this->handleContent();
    }

    private function handleContent(): void
    {
        if (function_exists('rank_math_get_breadcrumbs')) {
            $this->content = rank_math_get_breadcrumbs();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumbs');
    }
}
