<?php

declare(strict_types=1);

namespace App\Blocks\Reassurance;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\FontAwesomeIcon;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

class ReinsuranceBlock extends AbstractBlock
{
    public static ?string $slug = 'reinsurance';
    public static ?string $title = 'Réassurance';
    public static ?string $mode = 'preview';
    public static string $category = 'reassurance';

    final public const FIELD_ITEMS = 'items';
    final public const FIELD_ICON = 'icon';
    final public const FIELD_TITLE = 'title';
    final public const FIELD_DATA = 'data';
    final public const FIELD_TYPE = 'type';

    private const TITLE_MAX_LENGTH = 100;

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            Repeater::make(__('Éléments'), self::FIELD_ITEMS)
                ->minRows(3)
                ->maxRows(4)
                ->layout('block')
                ->fields([
                    FontAwesomeIcon::make(__('Icône'), self::FIELD_ICON),
                    Text::make(__('Donnée'), self::FIELD_DATA),
                    Text::make(__('Titre'), self::FIELD_TITLE)
                        ->maxLength(self::TITLE_MAX_LENGTH)
                        ->helperText(__(sprintf('Maximum %s caractères', self::TITLE_MAX_LENGTH))),
                ]),
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin(),
            LayoutField::darkMode(),
            ButtonGroup::make(__('Type'), self::FIELD_TYPE)
                ->choices([
                    'default' => __('Par défaut'),
                    'light' => __('Simple'),
                ]),
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