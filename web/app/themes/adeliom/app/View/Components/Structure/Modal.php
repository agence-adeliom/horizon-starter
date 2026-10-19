<?php

namespace App\View\Components\Structure;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public string $titleId;

    /**
     * Accessible name of the dialog: the `header` slot, or the id of a title in the content (`labelledby`),
     * or an `aria-label` when the dialog has no visible title.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $labelledby = null,
        public ?string $ariaLabel = null,
    ) {
        $this->titleId = ($this->id ?: wp_unique_id('modal-')) . '-title';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.structure.modal');
    }
}
