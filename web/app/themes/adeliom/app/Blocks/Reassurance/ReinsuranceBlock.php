<?php

declare(strict_types=1);

namespace App\Blocks\Reassurance;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\FontAwesomeIcon;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

class ReinsuranceBlock extends AbstractBlock
{
    final public const string FIELD_ITEMS = 'items';
    final public const string FIELD_ICON = 'icon';
    final public const string FIELD_TITLE = 'title';
    final public const string FIELD_DATA = 'data';
    private const int TITLE_MAX_LENGTH = 100;

    public static ?string $slug = 'reinsurance';
    public static ?string $title = 'Réassurance';
    public static string $category = 'reassurance';
    public static ?string $description = "Éléments visuels et textuels destinés à renforcer la confiance.";

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            Repeater::make(__('Éléments'), self::FIELD_ITEMS)
                ->minRows(3)
                ->maxRows(4)
                ->layout('block')
                ->collapsed(self::FIELD_TITLE)
                ->fields([
                    FontAwesomeIcon::make(__('Icône'), self::FIELD_ICON)->required(),
                    Text::make(__('Donnée'), self::FIELD_DATA),
                    Text::make(__('Titre'), self::FIELD_TITLE)
                        ->required()
                        ->maxLength(self::TITLE_MAX_LENGTH)
                        ->helperText(__(sprintf('Maximum %s caractères', self::TITLE_MAX_LENGTH))),
                ]),
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin(),
        ]);
    }
}