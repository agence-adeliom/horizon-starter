<?php

namespace App\View\Composers;

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

        if ($data = get_field(OptionPageAdmin::FIELDS_PARAM, 'option')) {
            if (is_array($data) && isset($data[OptionPageAdmin::MAIN_LOGO])) {
                $logo = $data[OptionPageAdmin::MAIN_LOGO];
            }
            if (is_array($data) && isset($data[OptionPageAdmin::HEADER_CTA])) {
                $headerCta = $data[OptionPageAdmin::HEADER_CTA];
            }
        }

        return [
            "logo" => $logo,
            "headerCta" => $headerCta,
            "primaryNavigation" => $primaryNavigation,
        ];
    }
}