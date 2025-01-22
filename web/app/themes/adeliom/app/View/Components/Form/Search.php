<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    public bool $isModal;
    /**
     * Create a new component instance.
     */
    public function __construct(
        ?bool $isModal = false,
    ) {
        $this->isModal = $isModal;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.search');
    }
}
