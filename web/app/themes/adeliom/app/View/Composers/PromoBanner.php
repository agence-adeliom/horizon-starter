<?php

namespace App\View\Composers;

use App\Admin\OptionPageAdmin;
use Roots\Acorn\View\Composer;

class PromoBanner extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
     */
    protected static $views = [
        "sections.promo-banner",
    ];

    protected function with()
    {
        $isActive = false;
        $isDark = false;
        $bannerTitle = null;
        $bannerLink = null;

        if ($options = get_field(OptionPageAdmin::FIELD_BANNER, 'option')) {
            if (is_array($options)) {
                if (isset($options[OptionPageAdmin::FIELD_PROMO_ACTIVE])) {
                    $isActive = $options[OptionPageAdmin::FIELD_PROMO_ACTIVE];
                }
                if (isset($options[OptionPageAdmin::FIELD_PROMO_DARK])) {
                    $isDark = $options[OptionPageAdmin::FIELD_PROMO_DARK];
                }
                if (isset($options[OptionPageAdmin::FIELD_BANNER_TITLE])) {
                    $bannerTitle = $options[OptionPageAdmin::FIELD_BANNER_TITLE];
                }
                if (isset($options[OptionPageAdmin::FIELD_BANNER_LINK])) {
                    $bannerLink = $options[OptionPageAdmin::FIELD_BANNER_LINK];
                }
            }
        }

        return [
            "isActive"    => $isActive,
            "isDark" => $isDark,
            "bannerTitle" => $bannerTitle,
            "bannerLink"  => $bannerLink,
        ];
    }
}
