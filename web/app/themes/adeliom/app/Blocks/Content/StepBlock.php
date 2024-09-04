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
use Extended\ACF\Fields\Text;

class StepBlock extends AbstractBlock
{
    final public const string FIELDS_STEPS = 'steps';
    final public const string FIELDS_STEP_TITLE = 'title';
    final public const string FIELDS_STEP_CONTENT = 'content';
    final public const string FIELDS_STEP_IMG = 'img';
    public static ?string $slug = 'step';
    public static ?string $title = 'Étapes';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            ButtonField::make(),
            Repeater::make("Étapes", self::FIELDS_STEPS)
                ->fields([
                    UptitleField::make()->required(),
                    Text::make("Titre de l'étape", self::FIELDS_STEP_TITLE)->required(),
                    WysiwygField::minimal("Contenu de l'étape", self::FIELDS_STEP_CONTENT)->required(),
                    Image::make("Image de l'étape", self::FIELDS_STEP_IMG)
                        ->required(),
                ])
                ->collapsed(self::FIELDS_STEP_TITLE)
                ->layout('block')
                ->minRows(3)
                ->maxRows(3),
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin(),
        ]);
    }


    public function renderBlockCallback(): void
    {
        return;
    }
}