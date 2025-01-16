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
        $primaryNavigation = new MenuViewModel("primary_navigation") ?? null;

        $logo = null;
        $headerCta = null;

        if ($data = get_field(OptionPageAdmin::FIELD_PARAM_FIELDS, 'option')) {
            if (is_array($data) && isset($data[OptionPageAdmin::FIELD_MAIN_LOGO])) {
                $logo = $data[OptionPageAdmin::FIELD_MAIN_LOGO];
            }
            if (is_array($data) && isset($data[OptionPageAdmin::FIELD_HEADER_CTA])) {
                $headerCta = $data[OptionPageAdmin::FIELD_HEADER_CTA];
            }
        }

        return [
            "logo" => $logo,
            "headerCta" => $headerCta,
            "primaryNavigation" => $primaryNavigation,
        ];
    }
}
