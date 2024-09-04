<?php

declare(strict_types=1);

namespace App\Blocks\Reassurance;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;

class LogosBlock extends AbstractBlock
{
    final public const string FIELD_LOGOS = 'logos';
    final public const string FIELD_LOGO = 'logo';
    final public const string FIELD_LINK = 'link';
    public static ?string $slug = 'logos';
    public static ?string $title = 'Logos';
    public static ?string $description = "Affiche une série de logos comme des clients, partenaires ou certifications.";

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            Repeater::make(__('Logos'), self::FIELD_LOGOS)
                ->minRows(2)
                ->maxRows(8)
                ->layout('block')
                ->collapsed(self::FIELD_LINK)
                ->fields([
                    Image::make(__('Logo'), self::FIELD_LOGO)->required(),
                    Link::make(__('Lien sur le logo'), self::FIELD_LINK),
                ]),

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