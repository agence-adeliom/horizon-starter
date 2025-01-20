<?php

declare(strict_types=1);

namespace App\Admin;

use Adeliom\HorizonTools\Admin\AbstractAdmin;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Text\IconField;
use App\Fields\Links\LinkField;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Number;

use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
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

    public const string FIELD_REVIEWS_FIELDS = "reviews";
    public const string FIELD_GLOBAL_RATING = "global-rating";
    public const string FIELD_BTN_REVIEWS = "btn-reviews";

    public const string FIELD_TOP_NAVIGATION = "top-navigation";
    public const string FIELD_TOP_NAVIGATION_ENABLED = "is-enabled";
    public const string FIELD_TOP_NAVIGATION_SHOW_SEARCH = "show-search";
    public const string FIELD_TOP_NAVIGATION_REVIEWS_TYPE = "reviews-type";
    public const string VALUE_TOP_NAVIGATION_REVIEWS_TYPE_HIDDEN = "hidden";
    public const string VALUE_TOP_NAVIGATION_REVIEWS_TYPE_DEFAULT = "default";
    public const string VALUE_TOP_NAVIGATION_REVIEWS_TYPE_DEFAULT_WITH_LINK = "default-with-link";
    public const string FIELD_TOP_NAVIGATION_REVIEWS_LINK_LABEL = "reviews-link-label";
    public const string FIELD_TOP_NAVIGATION_LINKS_REPEATER = "links";
    public const string FIELD_TOP_NAVIGATION_LINK = "link";

    public const string FIELD_BANNER = "banner";
    public const string FIELD_PROMO_ACTIVE = "is_active";
    public const string FIELD_PROMO_DARK = "is_dark";
    public const string FIELD_BANNER_TITLE = "title";
    public const string FIELD_BANNER_LINK = "link";

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

        yield Group::make('Paramètres des avis clients', self::FIELD_REVIEWS_FIELDS)
            ->fields([
                Number::make("Note globale", self::FIELD_GLOBAL_RATING)
                    ->helperText("Note attribuée à l'ensemble des avis clients, entre 0 et 5, par pas de 0.5")
                    ->min(0)
                    ->max(5)
                    ->step(0.5)
                    ->required(),
                ButtonField::make("Liens de tous les avis", self::FIELD_BTN_REVIEWS),
            ]);


        yield Tab::make("Navigation supérieure");

        yield Group::make("Paramètres de la navigation supérieure", self::FIELD_TOP_NAVIGATION)
            ->fields([
                TrueFalse::make("Activer la navigation supérieure", self::FIELD_TOP_NAVIGATION_ENABLED)
                    ->helperText('Permet d’afficher, ou non, la navigation supérieure.')
                    ->stylized(),
                TrueFalse::make("Activer la recherche", self::FIELD_TOP_NAVIGATION_SHOW_SEARCH)
                    ->stylized()
                    ->conditionalLogic([
                        ConditionalLogic::where(self::FIELD_TOP_NAVIGATION_ENABLED, "==", "1")
                    ]),
                ButtonGroup::make("Affichage des avis", self::FIELD_TOP_NAVIGATION_REVIEWS_TYPE)
                    ->helperText("Permet de choisir la façon dont les avis vont s’afficher dans la navigation supérieure.")
                    ->choices([
                        self::VALUE_TOP_NAVIGATION_REVIEWS_TYPE_DEFAULT => "Afficher",
                        self::VALUE_TOP_NAVIGATION_REVIEWS_TYPE_DEFAULT_WITH_LINK => "Afficher avec un lien vers la page d'avis",
                        self::VALUE_TOP_NAVIGATION_REVIEWS_TYPE_HIDDEN => "Masquer les avis",
                    ])->conditionalLogic([
                        ConditionalLogic::where(self::FIELD_TOP_NAVIGATION_ENABLED, "==", "1")
                    ]),
                Text::make("Libellé du lien vers les avis", self::FIELD_TOP_NAVIGATION_REVIEWS_LINK_LABEL)
                    ->required()
                    ->default("Lire les avis")
                    ->conditionalLogic([
                        ConditionalLogic::where(self::FIELD_TOP_NAVIGATION_REVIEWS_TYPE, "==", self::VALUE_TOP_NAVIGATION_REVIEWS_TYPE_DEFAULT_WITH_LINK)
                    ]),
                Repeater::make("Liens", self::FIELD_TOP_NAVIGATION_LINKS_REPEATER)
                    ->minRows(0)
                    ->maxRows(3)
                    ->layout('block')
                    ->fields([
                        LinkField::make(name: self::FIELD_TOP_NAVIGATION_LINK),
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where(self::FIELD_TOP_NAVIGATION_ENABLED, "==", "1")
                    ])
            ]);

        yield Tab::make("Bannière promotionnelle");

        yield Group::make('Paramètres de la bannière promotionnelle', self::FIELD_BANNER)
            ->fields([
                TrueFalse::make("Activer la bannière promotionnelle", self::FIELD_PROMO_ACTIVE)->stylized()->wrapper(['width' => 50]),
                TrueFalse::make("Activer le mode sombre", self::FIELD_PROMO_DARK)->stylized()->wrapper(['width' => 50]),
                Text::make("Texte de la bannière", self::FIELD_BANNER_TITLE),
                Link::make("Lien de la bannière", self::FIELD_BANNER_LINK)

            ]);
    }

    public function getStyle(): string
    {
        return "seamless";
    }
}
