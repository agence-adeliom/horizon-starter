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
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

class ArgumentBlock extends AbstractBlock
{
    public const string FIELD_ARGS = "args";
    public const string FIELD_ARG_TITLE = "arg_title";
    public const string FIELD_ARG_DESC = "arg_desc";
    public const string FIELD_ARG_IMG = "arg_img";
    public static ?string $slug = 'argument';
    public static ?string $title = 'ArgumentBlock';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            Repeater::make(__("Liste d'arguments"), self::FIELD_ARGS)
            ->fields([
                Text::make(__("Titre de l'argument"), self::FIELD_ARG_TITLE)->required(),
                Text::make(__("Description de l'argument"), self::FIELD_ARG_DESC)->required(),
                Image::make(__("Image de l'argument"), self::FIELD_ARG_IMG)->required(),
            ])
            ->collapsed(self::FIELD_ARG_TITLE)
            ->minRows(3)
            ->button(__("Ajouter un argument")),

            ButtonField::make()->required(),
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