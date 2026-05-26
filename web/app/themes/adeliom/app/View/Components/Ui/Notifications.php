<?php

declare(strict_types=1);

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notifications extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.ui.notifications');
    }
}
