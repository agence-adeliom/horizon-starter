<?php

declare(strict_types=1);

namespace App\Admin;

use Adeliom\HorizonTools\Admin\AbstractAdmin;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;

class OptionPageAdmin extends AbstractAdmin
{
    public static ?string $title = 'Paramètres';
    public static bool $isOptionPage = true;
    public static ?string $optionPageIcon = null;


    public const string PARAM_FIELDS = "param";
    public const string MAIN_LOGO = "main-logo";
    public const string WHITE_LOGO = "white-logo";
    public const string CLIENT_NAME = "client-name";


    public function getFields(): ?iterable
    {
            yield Tab::make("Général");
            yield Group::make('Paramètres principaux', self::PARAM_FIELDS)
                ->fields([
                    Text::make("Votre nom", self::CLIENT_NAME),
                    Image::make("Logo principal", self::MAIN_LOGO),
                    Image::make("Logo version blanche", self::WHITE_LOGO),
                ]);

    }

    public function getStyle(): string
    {
        return "seamless";
    }
}