<?php

namespace App\View\Components\Typography;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Heading extends Component
{
    final public const SIZES = [
        '1' => 'heading heading-1',
        '2' => 'heading heading-2',
        '3' => 'heading heading-3',
        '4' => 'heading heading-4',
        '5' => 'heading heading-5',
        '6' => 'heading heading-6',
        '7' => 'heading heading-7',
        'headline' => 'headline',
    ];

    public ?string $fullClass = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $fields = null,
        public string $tag = 'div',
        public string $content = '',
        public ?string $class = null,
        public string $size = '1',
    ) {
        $this->initializeClasses();
        $this->initializeProperties();
    }

    private function initializeProperties(): void
    {
        $this->content = $this->fields['content'] ?? $this->content;
        $this->tag = $this->fields['tag'] ?? $this->tag;
    }

    private function initializeClasses(): void
    {
        $this->fullClass = implode(' ', array_filter([
            self::SIZES[$this->size] ?? self::SIZES[1],
            $this->class ?? '',
        ]));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.typography.heading');
    }
}
