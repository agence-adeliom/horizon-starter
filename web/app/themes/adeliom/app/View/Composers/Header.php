<?php

namespace App\View\Composers;

use Adeliom\HorizonTools\ViewModels\Menu\MenuViewModel;
use App\Admin\OptionPageAdmin;
use Roots\Acorn\View\Composer;

class Header extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
     */
    protected static $views = [
        "sections.header",
        "sections.header-lp",
    ];

    protected function with()
    {
        return [
            "logo" => get_field(OptionPageAdmin::PARAM_FIELDS, 'option')[OptionPageAdmin::MAIN_LOGO],
        ];
    }
}