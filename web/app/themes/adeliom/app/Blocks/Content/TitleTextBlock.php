<?php

declare(strict_types=1);

namespace App\Blocks\Content;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;

class TitleTextBlock extends AbstractBlock
{
    public static ?string $slug = 'title-text';
    public static ?string $title = 'Titre texte';
    public static ?string $mode = 'preview';
    public static ?string $icon = 'analytics';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            HeadingField::make()->required(),
            WysiwygField::make()
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin(),
            LayoutField::darkMode(),
        ]);
    }
}