<?php

declare(strict_types=1);

namespace App\Blocks\Hero;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;
use App\Fields\FormField;
use App\Fields\OfferField;

class HeroForm extends AbstractBlock
{
    public static ?string $slug = 'hero-form';
    public static ?string $title = 'Haut de page avec formulaire';
    public static ?string $mode = 'preview';
    public static string $category = 'hero';

    public const string FORM_TITLE = "form-title";
    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            HeadingField::make()->required(),
            WysiwygField::make(),
            OfferField::make(),
            HeadingField::make("Titre au dessus du formulaire", self::FORM_TITLE)->required(),
            FormField::selectGF(),
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin(),
        ]);
    }
}