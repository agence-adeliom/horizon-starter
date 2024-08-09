<?php

declare(strict_types=1);

namespace App\View\Components\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardListing extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array|object $content
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.card-listing');
    }
}
