<?php

namespace App\View\Composers;

use Adeliom\HorizonTools\Fields\Text\UptitleField;
use App\Admin\OptionPageAdmin;
use Roots\Acorn\View\Composer;

class NotFound extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
     */
    protected static $views = [
        '404',
    ];

    protected function with()
    {
        $upTitle = '';
        $title = '';
        $firstCol = null;
        $secondCol = null;

        if ($options = get_field(OptionPageAdmin::FIELD_404, 'option')) {
            if (is_array($options)) {
                if (isset($options[UptitleField::NAME])) {
                    $upTitle = $options[UptitleField::NAME];
                }
                if (isset($options[OptionPageAdmin::FIELD_404_TITLE])) {
                    $title = $options[OptionPageAdmin::FIELD_404_TITLE];
                }
                if (isset($options[OptionPageAdmin::FIELD_404_FIRST_COLUMN])) {
                    $firstCol = $options[OptionPageAdmin::FIELD_404_FIRST_COLUMN];
                }
                if (isset($options[OptionPageAdmin::FIELD_404_SECOND_COLUMN])) {
                    $secondCol = $options[OptionPageAdmin::FIELD_404_SECOND_COLUMN];
                }
            }
        }


        return [
            "upTitle"    => $upTitle,
            "title"    => $title,
            "firstCol"    => $firstCol,
            "secondCol"    => $secondCol,
        ];
    }
}
