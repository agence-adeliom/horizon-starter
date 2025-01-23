<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Rating extends Component
{
    public float $score; // Note entre 0 et 5

    /**
     * Create a new component instance.
     */
    public function __construct(float $score = 0, public ?string $class = '', public bool $showScore = false)
    {
        $this->score = max(0, min(5, $score));
        $this->showScore = $showScore;
    }

    /**
     * Calculer le tableau des étoiles à afficher.
     */
    public function stars(): array
    {
        $fullStars = floor($this->score); // Nombre d'étoiles pleines
        $halfStar = ($this->score - $fullStars) >= 0.5 ? 1 : 0; // Si demi-étoile
        $emptyStars = 5 - $fullStars - $halfStar; // Reste en étoiles vides

        return array_merge(
            array_fill(0, $fullStars, 'full'), // Étoiles pleines
            array_fill(0, $halfStar, 'half'), // Demi-étoile
            array_fill(0, $emptyStars, 'empty') // Étoiles vides
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.ui.rating');
    }
}
