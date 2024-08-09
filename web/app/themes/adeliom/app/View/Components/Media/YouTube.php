<?php

namespace App\View\Components\Media;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class YouTube extends Component
{
    private array $allow = [
        'accelerometer',
        'autoplay',
        'clipboard-write',
        'encrypted-media',
        'gyroscope',
        'picture-in-picture',
        'web-share',
    ];

    public string $referrerPolicy = 'strict-origin-when-cross-origin';

    public ?string $allowAttribute = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?int    $width = 560,
        public ?int    $height = 315,
        public ?string $title = null,
        public bool    $allowFullscreen = true,
    )
    {
        $this->handleAllow();
    }

    private function handleAllow(): void
    {
        $this->allowAttribute = implode('; ', $this->allow) . ';';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.media.youtube');
    }
}
