<?php

declare(strict_types=1);

namespace App\Admin;

use Adeliom\HorizonTools\Admin\AbstractAdmin;
use Adeliom\HorizonTools\Fields\Text\IconField;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Text;
use Extended\ACF\Location;

class MenuAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    public const MENU_ITEM = 'menu_item';
    public static ?string $title = 'Menu item';

    public function getFields(): ?iterable
    {

        yield Group::make('Menu item', self::MENU_ITEM)
            ->fields([
                IconField::make(),
                Text::make("Label du CTA principal", "label")->helperText(__('(dans le cas où l\'item parent est un lien)')),
            ]);
    }


    public function getStyle(): string
    {
        return "seamless";
    }

    /**
     * @see https://github.com/vinkla/extended-acf#location
     */
    public function getLocation(): iterable
    {
        yield Location::where('nav_menu_item', '=', "3");
    }
}