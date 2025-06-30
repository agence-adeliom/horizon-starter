<?php

declare(strict_types=1);

namespace App\View\Components\Cards\ListingCards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BasicCard extends Component
{
    public const string NAME = 'Card basique';

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.listing-cards.basic-card');
    }
}
