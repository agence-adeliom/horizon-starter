<?php

declare(strict_types=1);

namespace App\Admin;

use Adeliom\HorizonTools\Admin\AbstractAdmin;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Text\IconField;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\URL;

class OptionPageAdmin extends AbstractAdmin
{
    public static ?string $title = 'Paramètres';
    public static bool $isOptionPage = true;
    public static ?string $optionPageIcon = null;

    public const string FIELD_PARAM_FIELDS = "param";
    public const string FIELD_FOOTER_FIELDS = "footer";
    public const string FIELD_SOCIAL_NETWORKS = "social-networks";
    public const string FIELD_MAIN_LOGO = "main-logo";
    public const string FIELD_WHITE_LOGO = "white-logo";
    public const string FIELD_CLIENT_NAME = "client-name";
    public const string FIELD_CLIENT_BASELINE = "client-baseline";
    public const string FIELD_HEADER_CTA = "header-cta";

    public const string FIELD_MAIN_NAVIGATION_TITLE = "main-navigation-title";
    public const string FIELD_SECOND_NAVIGATION_TITLE = "second-navigation-title";
    public const string FIELD_TITLE_HIGHLIGHT = "title-highlight";
    public const string FIELD_BTN_HIGHLIGHT = "btn-highlight";
    public const string FIELD_FOOTER_TITLE = "footer-title";
    public const string FIELD_FOOTER_TEXT = "footer-text";

    public const string FIELDS_REVIEWS = "reviews";
    public const string GLOBAL_RATING = "global-rating";
    public const string BTN_REVIEWS = "btn-reviews";

    public function getFields(): ?iterable
    {
        yield Tab::make("Général");

        yield Group::make('Paramètres principaux', self::FIELD_PARAM_FIELDS)
            ->fields([
                Text::make("Votre nom", self::FIELD_CLIENT_NAME),
                Text::make("Votre baseline", self::FIELD_CLIENT_BASELINE)->helperText("Utilisée dans le pied de page."),
                ButtonField::make("Bouton d'action principal du header", self::FIELD_HEADER_CTA),
                Image::make("Logo principal", self::FIELD_MAIN_LOGO),
                Image::make("Logo version blanche", self::FIELD_WHITE_LOGO),
                Repeater::make("Réseaux sociaux", self::FIELD_SOCIAL_NETWORKS)
                    ->fields([
                        URL::make("Lien", "link"),
                        IconField::make()->format("object"),
                    ])
                    ->maxRows(6),
            ]);

        yield Tab::make("Pied de page");
        yield Group::make('Paramètres du pied de page', self::FIELD_FOOTER_FIELDS)
            ->fields([
                Text::make("Titre", self::FIELD_FOOTER_TITLE),
                Text::make("Texte", self::FIELD_FOOTER_TEXT),
                Text::make("Titre de la navigation principale", self::FIELD_MAIN_NAVIGATION_TITLE),
                Text::make("Titre de la navigation secondaire", self::FIELD_SECOND_NAVIGATION_TITLE),
                Text::make("Titre de l'encart", self::FIELD_TITLE_HIGHLIGHT),
                ButtonField::make("Bouton de l'encart", self::FIELD_BTN_HIGHLIGHT),
            ]);


        yield Tab::make("Avis clients");
        yield Group::make('Paramètres du pied de page', self::FIELDS_REVIEWS)
            ->fields([
                Number::make("Note globale", self::GLOBAL_RATING)
                    ->helperText("Note attribuée à l'ensemble des avis clients, entre 0 et 5, par pas de 0.5")
                    ->min(0)
                    ->max(5)
                    ->step(0.5)
                    ->required(),
                ButtonField::make("Liens de tous les avis", self::BTN_REVIEWS),
            ]);
    }

    public function getStyle(): string
    {
        return "seamless";
    }
}
