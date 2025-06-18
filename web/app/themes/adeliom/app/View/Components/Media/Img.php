<?php

declare(strict_types=1);

namespace App\View\Components\Media;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Img extends Component
{
    /**
     * Image ID
     *
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Generated image HTML
     *
     * @var string|null
     */
    public ?string $content = null;

    /**
     * Image component instance
     *
     * @param array|null  $image            Image array (e.g. ['ID' => 123]).
     * @param string|null $size             Image size (from Wordpress) : 'thumbnail', 'small', 'medium', 'medium_large', 'large' (default), 'full'.
     * @param string|null $class            Image classes.
     * @param string|null $loading          Image loading attribute : 'lazy' (default), 'eager', 'auto'.
     * @param string|null $containerClass   Container CSS classes. Default : null.
     * @param string|null $ratio            Image ratio (e.g. '16:9', '4:3').
     * @param bool|null   $decorative       Is image decorative.
     */
    public function __construct(
        public null|false|array $image = null,
        public ?string $size = 'large',
        public ?string $class = null,
        public ?string $loading = 'lazy',
        public ?string $containerClass = null,
        public ?string $ratio = null,
        public ?bool   $decorative = false,
    ) {
        $this->handleData();
    }

    private function handleData(): void
    {
        if (is_array($this->image) && isset($this->image['ID'])) {
            $this->id = $this->image['ID'];
        }

        if ($this->id) {
            $attr = [
                'class' => $this->class,
                'loading' => $this->loading,
            ];
            if ($this->decorative) {
                $attr['role'] = "presentation";
            }

            $this->content = wp_get_attachment_image(attachment_id: $this->id, size: $this->size, attr: $attr);

            $this->containerClass = trim(implode(' ', [
                null !== $this->containerClass ? $this->containerClass : 'relative',
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
