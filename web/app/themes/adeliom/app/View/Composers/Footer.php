<?php

namespace App\View\Composers;

use Adeliom\HorizonTools\ViewModels\Menu\MenuViewModel;
use App\Admin\OptionPageAdmin;
use Roots\Acorn\View\Composer;

class Footer extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
     */
    protected static $views = [
        "sections.footer",
    ];

    protected function with()
    {
        return [
            "clientName" => get_field(OptionPageAdmin::PARAM_FIELDS, 'option')[OptionPageAdmin::CLIENT_NAME],
            "logoFooter" => get_field(OptionPageAdmin::PARAM_FIELDS, 'option')[OptionPageAdmin::WHITE_LOGO],
            "legalsMenu" => new MenuViewModel("legals_navigation"),
        ];
    }
}