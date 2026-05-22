<?php

declare(strict_types=1);

namespace App\View\Components;

use Adeliom\HorizonTools\Services\SeoService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class A extends Component
{
    public ?string $hrefAttribute = null;

    public function __construct(
        public ?string $href,
        public ?string $target = null,
        public readonly ?string $rel = null,
        public readonly ?string $ariaLabel = null,
        public string $tag = 'a',
        public ?string $id = null,
        public ?string $tabindex = null,
        public ?string $role = null,
        public ?string $title = null,
        public readonly ?string $type = null,
        public readonly bool $obfuscate = false,
        public ?string $class = null,
        public ?string $wireClick = null,
        public ?string $wireTarget = null,
        public bool $handleLivewireLoading = false,
        public bool $openAuthForm = false,
        public bool $openNewsletterForm = false,
        public ?string $atClick = null,
        public ?string $xShow = null,
    ) {
        $this->handleAuthForm();
        $this->handleObfuscation();
    }

    private function handleAuthForm(): void
    {
        if ($this->openAuthForm || $this->openNewsletterForm) {
            $this->href = null;
            $this->target = null;

            if (!empty($this->wireClick)) {
                $this->wireTarget = null;
                $this->wireClick = null;
                $this->handleLivewireLoading = false;
            }
        }
    }

    private function handleObfuscation(): void
    {
        if (null === $this->class) {
            $this->class = '';
        }

        if ($this->handleLivewireLoading) {
            $this->class = implode(' ', [$this->class, 'handle-lw-loading']);
        }

        if ($this->obfuscate && !empty($this->href)) {
            $this->tag = SeoService::getObfuscationTag();
            $this->hrefAttribute = SeoService::getHrefAttribute(url: $this->href, obfuscate: true);

            if (null === $this->class) {
                $this->class = '';
            }

            $obfuscationClass = SeoService::getObfuscationClass();

            if (!empty($obfuscationClass)) {
                $this->class = rtrim(sprintf('%s %s', $obfuscationClass, $this->class));
            }
        } elseif (!empty($this->href)) {
            $this->hrefAttribute = sprintf('href="%s"', esc_url($this->href));
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.a');
    }
}
