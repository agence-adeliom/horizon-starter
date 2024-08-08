<?php

declare(strict_types=1);

namespace App\Blocks\Hero;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Tabs\MediaTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;
use App\Fields\FormField;
use App\Fields\OfferField;
use Extended\ACF\Fields\Image;

class Hero extends AbstractBlock
{
    public static ?string $slug = 'hero';
    public static ?string $title = 'Haut de page';
    public static ?string $mode = 'preview';
    public static string $category = 'hero';

    public const string MAIN_IMAGE = "main_image";

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            WysiwygField::make(),
            ButtonField::group(),
        ]);

        yield from MediaTab::make()->fields([
            Image::make("Image principale", self::MAIN_IMAGE),
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin(),
        ]);
    }

}