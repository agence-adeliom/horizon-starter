<?php

declare(strict_types=1);

namespace App\Blocks\Listing;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Select\PostTypeSelectField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Adeliom\HorizonTools\Services\BudService;
use Extended\ACF\Fields\Number;

class ListingBlock extends AbstractBlock
{
    public static ?string $slug = 'listing';
    public static ?string $title = 'Liste d’éléments';
    public static ?string $mode = 'preview';

    final public const FIELD_PER_PAGE = 'perPage';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            PostTypeSelectField::make(),
        ]);

        yield from LayoutTab::make()->fields([
            Number::make(__('Nombre d’éléments par page'), self::FIELD_PER_PAGE)
                ->max(24)
                ->min(3)
                ->step(3)
        ]);
    }

    public function addToContext(): array
    {
        return [];
    }

    public function renderBlockCallback(): void
    {
        wp_enqueue_script('listing-block-js', BudService::getUrl('listing.js'));
    }
}
