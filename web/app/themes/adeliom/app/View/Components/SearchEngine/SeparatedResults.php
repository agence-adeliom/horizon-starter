<?php

declare(strict_types=1);

namespace App\View\Components\SearchEngine;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SeparatedResults extends Component
{
    public function __construct(public readonly array $results, public readonly bool $displayTypeFilters = true, public readonly array $typeChoices = [])
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.search-engine.separated-results');
    }
}
