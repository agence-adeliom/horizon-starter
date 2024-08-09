<?php

declare(strict_types=1);

namespace App\Blocks\Reassurance;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Tabs\MediaTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\RadioButton;

class Quote extends AbstractBlock
{

    public static ?string $slug = 'quote';
    public static ?string $title = 'Citation';
    public static ?string $mode = 'preview';
    public static string $category = 'reassurance';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            HeadingField::make()->required(),
        ]);
    }

}