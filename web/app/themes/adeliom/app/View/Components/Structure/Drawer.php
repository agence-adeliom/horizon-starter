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

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $position = 'right'
    ) {
        if (!in_array($position, ['top', 'bottom', 'left', 'right'])) {
            throw new InvalidArgumentException("La position '{$position}' n'est pas valide. Les positions autorisées sont : 'top', 'bottom', 'left', 'right'.");
        }

        $this->positionClass = $this->getPositionClass($position);
        $this->transitionClass = $this->getTransitionClass($position);
    }

    private function getPositionClass(string $position): string
    {
        return match ($position) {
            'top' => 'top-0 left-0 w-full h-1/3 mb-auto',
            'bottom' => 'bottom-0 left-0 w-full h-1/3 mt-auto',
            'left' => 'top-0 left-0 h-full w-1/3 mr-auto',
            'right' => 'top-0 right-0 h-full w-1/3 ml-auto',
            default => 'top-0 right-0 h-full w-1/3 ml-auto',
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
