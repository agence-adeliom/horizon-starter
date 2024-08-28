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
use Adeliom\HorizonTools\Fields\Text\WysiwygField;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

class KeyFigureBlock extends AbstractBlock
{
    final public const string FIELD_ITEMS = 'items';
    final public const string FIELD_ICON = 'icon';
    final public const string FIELD_TITLE = 'title';
    final public const string FIELD_DATA = 'data';
    final public const FIELD_TYPE = 'type';
    private const int TITLE_MAX_LENGTH = 100;
    public static ?string $slug = 'key-figure';
    public static ?string $title = 'Chiffres clés';
    public static ?string $description = "Chiffres percutants destinés à renforcer la crédibilité ou souligner des données marquantes.";

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            WysiwygField::minimal(),
            Repeater::make(__('Éléments'), self::FIELD_ITEMS)
                ->minRows(3)
                ->maxRows(4)
                ->layout('block')
                ->collapsed(self::FIELD_TITLE)
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
            ButtonGroup::make(__('Type'), self::FIELD_TYPE)
                ->choices([
                    'default' => __('Par défaut'),
                    'with_bg' => __('Avec fond'),
                    'framed'  => __('Cartouches encadrées'),
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