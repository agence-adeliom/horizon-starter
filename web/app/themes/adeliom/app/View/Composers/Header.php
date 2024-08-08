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
        $logo = null;

        if ($data = get_field(OptionPageAdmin::PARAM_FIELDS, 'option')) {
            if (is_array($data) && isset($data[OptionPageAdmin::MAIN_LOGO])) {
                $logo = $data[OptionPageAdmin::MAIN_LOGO];
            }
        }

        return [
            "logo" => $logo,
        ];
    }
}
