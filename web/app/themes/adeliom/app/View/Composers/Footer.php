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
        $clientName = null;
        $logoFooter = null;

        if ($options = get_field(OptionPageAdmin::PARAM_FIELDS, 'option')) {
            if (is_array($options)) {
                if (isset($options[OptionPageAdmin::CLIENT_NAME])) {
                    $clientName = $options[OptionPageAdmin::CLIENT_NAME];
                }

                if (isset($options[OptionPageAdmin::WHITE_LOGO])) {
                    $logoFooter = $options[OptionPageAdmin::WHITE_LOGO];
                }
            }
        }

        return [
            "clientName" => $clientName,
            "logoFooter" => $logoFooter,
            "legalsMenu" => new MenuViewModel("legals_navigation"),
        ];
    }
}
