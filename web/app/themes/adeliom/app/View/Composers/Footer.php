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


        if ($options = get_field(OptionPageAdmin::FIELD_PARAM_FIELDS, 'option')) {
            if (is_array($options)) {
                if (isset($options[OptionPageAdmin::FIELD_CLIENT_NAME])) {
                    $clientName = $options[OptionPageAdmin::FIELD_CLIENT_NAME];
                }

                if (isset($options[OptionPageAdmin::FIELD_WHITE_LOGO])) {
                    $logoFooter = $options[OptionPageAdmin::FIELD_WHITE_LOGO];
                }
                if (isset($options[OptionPageAdmin::FIELD_CLIENT_BASELINE])) {
                    $clientBaseline = $options[OptionPageAdmin::FIELD_CLIENT_BASELINE];
                }

                if (isset($options[OptionPageAdmin::FIELD_SOCIAL_NETWORKS])) {
                    $socialNetworks = $options[OptionPageAdmin::FIELD_SOCIAL_NETWORKS];
                }
            }
        }


        if ($options = get_field(OptionPageAdmin::FIELD_FOOTER_FIELDS, 'option')) {
            if (isset($options[OptionPageAdmin::FIELD_FOOTER_TITLE])) {
                $footerTitle = $options[OptionPageAdmin::FIELD_FOOTER_TITLE];
            }

            if (isset($options[OptionPageAdmin::FIELD_FOOTER_TEXT])) {
                $footerText = $options[OptionPageAdmin::FIELD_FOOTER_TEXT];
            }

            if (isset($options[OptionPageAdmin::FIELD_MAIN_NAVIGATION_TITLE])) {
                $primaryNavTitle = $options[OptionPageAdmin::FIELD_MAIN_NAVIGATION_TITLE];
            }

            if (isset($options[OptionPageAdmin::FIELD_SECOND_NAVIGATION_TITLE])) {
                $secondNavTitle = $options[OptionPageAdmin::FIELD_SECOND_NAVIGATION_TITLE];
            }

            if (isset($options[OptionPageAdmin::FIELD_TITLE_HIGHLIGHT])) {
                $titleHighlight = $options[OptionPageAdmin::FIELD_TITLE_HIGHLIGHT];
            }

            if (isset($options[OptionPageAdmin::FIELD_BTN_HIGHLIGHT])) {
                $btnHighlight = $options[OptionPageAdmin::FIELD_BTN_HIGHLIGHT];
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
