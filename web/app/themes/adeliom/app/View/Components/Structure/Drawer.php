<?php

namespace App\View\Components\Structure;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use InvalidArgumentException;

class Drawer extends Component
{
    public string $positionClass;
    public string $transitionClass;
    public string $titleId;

    /**
     * Accessible name of the dialog: the `header` slot, or the id of a title in the content (`labelledby`),
     * or an `aria-label` when the dialog has no visible title.
     */
    public function __construct(
        string $position = 'right',
        public ?string $id = null,
        public ?string $labelledby = null,
        public ?string $ariaLabel = null,
    ) {
        if (!in_array($position, ['top', 'bottom', 'left', 'right'])) {
            throw new InvalidArgumentException("La position '{$position}' n'est pas valide. Les positions autorisées sont : 'top', 'bottom', 'left', 'right'.");
        }

        $this->positionClass = $this->getPositionClass($position);
        $this->transitionClass = $this->getTransitionClass($position);
        $this->titleId = ($this->id ?: wp_unique_id('drawer-')) . '-title';
    }

    private function getPositionClass(string $position): string
    {
        return match ($position) {
            'top' => 'top-0 left-0 w-full h-1/3 mb-auto',
            'bottom' => 'bottom-0 left-0 w-full h-1/3 mt-auto',
            'left' => 'top-0 left-0 h-full w-full mr-auto md:w-1/2 lg:w-1/3',
            'right' => 'top-0 right-0 h-full w-full ml-auto md:w-1/2 lg:w-1/3',
            default => 'top-0 right-0 h-full w-full ml-auto md:w-1/2 lg:w-1/3',
        };
    }


    private function getTransitionClass(string $position): string
    {
        return match ($position) {
            'top' => '-translate-y-20',
            'bottom' => 'translate-y-20',
            'left' => '-translate-x-20',
            'right' => 'translate-x-20',
            default => 'translate-x-20',
        };
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.structure.drawer');
    }
}
