<?php

namespace App\View\Components\Media;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Video extends Component
{
    public ?string $url = null;
    public ?string $mimeType = null;
    public ?string $unsupportedMessage = 'Votre navigateur ne supporte pas la balise vidéo.';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $video = null,
        public ?int   $width = 560,
        public ?int   $height = 315,
        public bool   $controls = true,
        public bool   $autoplay = false,
        public ?string $ratio = null,
        public ?string $containerClass = null,
        public ?string $class = null,
    )
    {
        $this->handleData();
    }

    private function handleData(): void
    {
        if (isset($this->video['url'])) {
            $this->url = $this->video['url'];
        }

        if (isset($this->video['mime_type'])) {
            $this->mimeType = $this->video['mime_type'];
        }

        $this->containerClass = trim(implode(' ', [
            null !== $this->containerClass ? $this->containerClass : 'relative',
            $this->ratio,
        ]));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.media.video');
    }
}
