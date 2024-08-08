<?php

declare(strict_types=1);

namespace App\Blocks\Content;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;

class Cards extends AbstractBlock
{
    public static ?string $slug = 'cards';
    public static ?string $title = '2 cartouches';
    public static ?string $mode = 'preview';
    public static string $category = 'content';

    public const string CARDS = 'cards';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
           Repeater::make("Cartouches", self::CARDS)
           ->fields([
               HeadingField::make()->required(),
               WysiwygField::minimal(),
               ButtonField::make()->required(),
               Image::make("Image", "img")->required()
           ])
           ->minRows(2)
           ->maxRows(2)
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin()
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