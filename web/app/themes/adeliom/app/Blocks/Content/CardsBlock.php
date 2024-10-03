<?php

declare(strict_types=1);

namespace App\Blocks\Content;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;

class CardsBlock extends AbstractBlock
{
    public const string FIELD_CARDS = 'cards';
    public static ?string $slug = 'cards';
    public static ?string $title = 'Remontée de 2 cartes';
    public static ?string $description = 'Affiche deux cartes cliquables, menant chacune vers une page spécifique.';
    public static string $category = 'content';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            WysiwygField::minimal(),
            Repeater::make("Cartouches", self::FIELD_CARDS)
                ->fields([
                    HeadingField::make()->required(),
                    WysiwygField::minimal(),
                    ButtonField::make()->required(),
                    Image::make("Image", "img")->required(),
                ])
                ->layout('row')
                ->minRows(2)
                ->maxRows(2),
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin(),
        ]);
    }

    public function addToContext(): array
    {
        return [];
    }

    public function renderBlockCallback(): void
    {
        return;
    }
}