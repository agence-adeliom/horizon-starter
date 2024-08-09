<?php

declare(strict_types=1);

namespace App\View\Components\Media;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Img extends Component
{
    public ?int $id = null;
    public ?string $content;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array  $image,
        public ?string $size = 'large',
        public ?string $class = null,
        public ?string $containerClass = null,
        public ?string $ratio = null,
    )
    {
        $this->handleData();
    }

    private function handleData(): void
    {
        if (is_array($this->image) && isset($this->image['ID'])) {
            $this->id = $this->image['ID'];
        }

        if ($this->id) {
            $this->content = wp_get_attachment_image(attachment_id: $this->id, size: $this->size, attr: [
                'class' => $this->class,
            ]);

            $this->containerClass = trim(implode(' ', [
                $this->containerClass,
                'relative',
                $this->ratio,
            ]));
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.media.img');
    }
}
