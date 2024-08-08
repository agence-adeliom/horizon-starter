<?php

declare(strict_types=1);

namespace App\Blocks\Action;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;

class CtaBlock extends AbstractBlock
{
    public static ?string $slug = 'cta';
    public static ?string $title = 'Call to Action';
    public static ?string $mode = 'preview';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            HeadingField::make()->required(),
            WysiwygField::simple(),
            ButtonField::types()
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin()
        ]);
    }
}
