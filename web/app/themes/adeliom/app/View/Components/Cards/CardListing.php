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
     * @param string $headingTag Niveau du titre de la carte, selon sa place dans la page 
     */
    public function __construct(
        public array|object $content,
        public string $headingTag = 'h3',
    ) {
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
