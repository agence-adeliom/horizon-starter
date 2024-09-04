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
        "sections.footer-lp",
    ];

    protected function with()
    {
        $clientName = null;
        $logoFooter = null;
        $clientBaseline = null;

        $footerTitle = null;
        $footerText = null;
        $socialNetworks = null;
        $primaryNavTitle = null;
        $secondNavTitle = null;
        $titleHighlight = null;
        $btnHighlight = null;

        $legalsNavigation = new MenuViewModel("legals_navigation") ?? null;
        $primaryFooterNavigation = new MenuViewModel("primary_footer_navigation") ?? null;
        $secondaryFooterNavigation = new MenuViewModel("secondary_footer_navigation") ?? null;


        if ($options = get_field(OptionPageAdmin::FIELDS_PARAM, 'option')) {
            if (is_array($options)) {
                if (isset($options[OptionPageAdmin::CLIENT_NAME])) {
                    $clientName = $options[OptionPageAdmin::CLIENT_NAME];
                }

                if (isset($options[OptionPageAdmin::WHITE_LOGO])) {
                    $logoFooter = $options[OptionPageAdmin::WHITE_LOGO];
                }
                if (isset($options[OptionPageAdmin::CLIENT_BASELINE])) {
                    $clientBaseline = $options[OptionPageAdmin::CLIENT_BASELINE];
                }

                if (isset($options[OptionPageAdmin::SOCIAL_NETWORKS])) {
                    $socialNetworks = $options[OptionPageAdmin::SOCIAL_NETWORKS];
                }
            }
        }


        if ($options = get_field(OptionPageAdmin::FIELDS_FOOTER, 'option')) {
            if (isset($options[OptionPageAdmin::FOOTER_TITLE])) {
                $footerTitle = $options[OptionPageAdmin::FOOTER_TITLE];
            }

            if (isset($options[OptionPageAdmin::FOOTER_TEXT])) {
                $footerText = $options[OptionPageAdmin::FOOTER_TEXT];
            }

            if (isset($options[OptionPageAdmin::MAIN_NAVIGATION_TITLE])) {
                $primaryNavTitle = $options[OptionPageAdmin::MAIN_NAVIGATION_TITLE];
            }

            if (isset($options[OptionPageAdmin::SECOND_NAVIGATION_TITLE])) {
                $secondNavTitle = $options[OptionPageAdmin::SECOND_NAVIGATION_TITLE];
            }

            if (isset($options[OptionPageAdmin::TITLE_HIGHLIGHT])) {
                $titleHighlight = $options[OptionPageAdmin::TITLE_HIGHLIGHT];
            }

            if (isset($options[OptionPageAdmin::BTN_HIGHLIGHT])) {
                $btnHighlight = $options[OptionPageAdmin::BTN_HIGHLIGHT];
            }
        }

        return [
            "clientName"          => $clientName,
            "clientBaseline"      => $clientBaseline,
            "logoFooter"          => $logoFooter,
            "legalsMenu"          => $legalsNavigation,
            "primaryFooterMenu"   => $primaryFooterNavigation,
            "secondaryFooterMenu" => $secondaryFooterNavigation,
            "footerTitle"         => $footerTitle,
            "footerText"          => $footerText,
            "socialNetworks"      => $socialNetworks,
            "primaryNavTitle"     => $primaryNavTitle,
            "secondNavTitle"      => $secondNavTitle,
            "titleHighlight"      => $titleHighlight,
            "btnHighlight"        => $btnHighlight,
        ];
    }
}