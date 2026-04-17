<?php

declare(strict_types=1);

namespace App\View\Components\Ui;

use BladeUI\Icons\Factory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class Icon extends Component
{
    public readonly bool $canDisplay;

    public function __construct(public string|stdClass $icon, public ?string $class = '', public ?string $iconName = '', public ?string $ariaLabel = null)
    {
        if (is_string($this->icon)) {
            if (
                str_starts_with($this->icon, 'far-') ||
                str_starts_with($this->icon, 'fas-') ||
                str_starts_with($this->icon, 'fab-') ||
                str_starts_with($this->icon, 'fal-')
            ) {
                $this->iconName = $this->icon;
            } else {
                $iconName = $this->icon;
                $this->icon = new stdClass();
                $this->icon->id = $iconName;
                $this->icon->style = 'regular';

                $this->formatIconName($this->icon);
            }
        } else {
            $this->formatIconName($this->icon);
        }

        $this->canDisplay = $this->validateIcon();
    }

    private function validateIcon(): bool
    {
        try {
            app(Factory::class)->svg($this->iconName);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function formatIconName($iconObject): void
    {
        $prefix = match ($iconObject->style) {
            'regular' => 'far',
            'brands' => 'fab',
            'light' => 'fal',
            'thin' => 'fat',
            'kit' => 'fa-kit',
            default => 'fas',
        };

        $this->iconName = "{$prefix}-{$iconObject->id}";
    }

    public function render(): View|Closure|string
    {
        return view('components.ui.icon');
    }
}
