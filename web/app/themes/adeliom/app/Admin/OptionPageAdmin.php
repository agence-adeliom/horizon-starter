<?php

declare(strict_types=1);

namespace App\Admin;

use Adeliom\HorizonTools\Admin\AbstractAdmin;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Text\FontAwesomeIcon;
use Adeliom\HorizonTools\Fields\Text\IconField;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\IconPicker;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\URL;

class OptionPageAdmin extends AbstractAdmin
{
    public static ?string $title = 'Paramètres';
    public static bool $isOptionPage = true;
    public static ?string $optionPageIcon = null;


    public const string PARAM_FIELDS = "param";
    public const string FOOTER_FIELDS = "footer";

    public const string SOCIAL_NETWORKS = "social-networks";

    public const string MAIN_LOGO = "main-logo";
    public const string WHITE_LOGO = "white-logo";
    public const string CLIENT_NAME = "client-name";
    public const string CLIENT_BASELINE = "client-baseline";


    public const string MAIN_NAVIGATION_TITLE = "main-navigation-title";
    public const string SECOND_NAVIGATION_TITLE = "second-navigation-title";
    public const string TITLE_HIGHLIGHT = "title-highlight";
    public const string BTN_HIGHLIGHT = "btn-highlight";

    public const string FOOTER_TITLE = "footer-title";
    public const string FOOTER_TEXT = "footer-text";

    public function getFields(): ?iterable
    {
        yield Tab::make("Général");
        yield Group::make('Paramètres principaux', self::PARAM_FIELDS)
            ->fields([
                Text::make("Votre nom", self::CLIENT_NAME),
                Text::make("Votre baseline", self::CLIENT_BASELINE)->helperText("Utilisée dans le pied de page."),
                Image::make("Logo principal", self::MAIN_LOGO),
                Image::make("Logo version blanche", self::WHITE_LOGO),
                Repeater::make("Réseaux sociaux", self::SOCIAL_NETWORKS)
                    ->fields([
                        URL::make("Lien", "link"),
                        IconField::make()
                    ])
                ->maxRows(6)
            ]);

        yield Tab::make("Pied de page");
        yield Group::make('Paramètres du pied de page', self::FOOTER_FIELDS)
            ->fields([
                Text::make("Titre", self::FOOTER_TITLE),
                Text::make("Texte", self::FOOTER_TEXT),
                Text::make("Titre de la navigation principale", self::MAIN_NAVIGATION_TITLE),
                Text::make("Titre de la navigation secondaire", self::SECOND_NAVIGATION_TITLE),
                Text::make("Titre de l'encart", self::TITLE_HIGHLIGHT),
                ButtonField::make("Bouton de l'encart", self::BTN_HIGHLIGHT),
            ]);
    }

    public function getStyle(): string
    {
        return "seamless";
    }
}