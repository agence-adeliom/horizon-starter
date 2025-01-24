<?php

namespace App\View\Components\Typography;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    public string $fullClass;
    public string $tag = 'p';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string      $class = null,
        public string|array $content = '',
    ) {
        $this->initializeContent();
        $this->handleFullClass();
    }

    private function initializeContent(): void
    {
        if (is_array($this->content) && isset($this->content['wysiwyg'])) {
            $this->content = $this->content['wysiwyg'];
            $this->tag = 'div';
        } else if (is_string($this->content) && preg_match('/<\s*[a-z][^>]*>/i', $this->content)) {
            $this->tag = 'div';
        }
    }


    private function handleFullClass(): void
    {
        $this->fullClass = implode(' ', [
            $this->tag === 'p' ? 'p' : 'wysiwyg',
            $this->class,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.typography.text');
    }
}
