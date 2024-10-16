<?php

namespace App\View\Composers;

use App\Admin\PromoBannerAdmin;
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
        $bannerTitle = null;
        $bannerLink = null;

        if ($options = get_field(PromoBannerAdmin::FIELD_BANNER, 'option')) {
            if (is_array($options)) {
                if (isset($options[PromoBannerAdmin::FIELD_PROMO_ACTIVE])) {
                    $isActive = $options[PromoBannerAdmin::FIELD_PROMO_ACTIVE];
                }

                if (isset($options[PromoBannerAdmin::FIELD_BANNER_TITLE])) {
                    $bannerTitle = $options[PromoBannerAdmin::FIELD_BANNER_TITLE];
                }
                if (isset($options[PromoBannerAdmin::FIELD_BANNER_LINK])) {
                    $bannerLink = $options[PromoBannerAdmin::FIELD_BANNER_LINK];
                }
            }
        }

        return [
            "isActive"    => $isActive,
            "bannerTitle" => $bannerTitle,
            "bannerLink"  => $bannerLink,
        ];
    }
}