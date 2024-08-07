<?php

declare(strict_types=1);

namespace App\Blocks\Listing;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Select\PostTypeSelectField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;

class ListingBlock extends AbstractBlock
{
    public static ?string $slug = 'listing';
    public static ?string $title = 'ListingBlock';
    public static ?string $mode = 'preview';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            HeadingField::make(),
            PostTypeSelectField::make(),
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
