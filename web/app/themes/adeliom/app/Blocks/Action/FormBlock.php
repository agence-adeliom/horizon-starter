<?php

declare(strict_types=1);

namespace App\Blocks\Action;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Services\FormService;
use App\Fields\FormField;
use App\Fields\OfferField;

class FormBlock extends AbstractBlock
{
    public static ?string $slug = 'form';
    public static ?string $title = 'Formulaire';
    public static ?string $mode = 'preview';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            HeadingField::make()->required(),
            OfferField::make(),
            FormField::selectGF(FormService::getAllFormChoices())
        ]);
    }
}