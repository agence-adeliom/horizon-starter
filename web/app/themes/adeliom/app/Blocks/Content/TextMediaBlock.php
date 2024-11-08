<?php

declare(strict_types=1);

namespace App\Blocks\Content;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Medias\MediaField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Tabs\MediaTab;
use Adeliom\HorizonTools\Fields\Tabs\SettingsTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;
use Adeliom\HorizonTools\Services\BudService;

class TextMediaBlock extends AbstractBlock
{
    public static ?string $slug = 'text-media';
    public static ?string $title = 'Texte + média';
    public static ?string $description = 'Combine contenu texte et élément visuel (image ou vidéo) pour apporter de l’information.';
    public static ?string $mode = 'preview';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            WysiwygField::make(),
            ButtonField::group(),
        ]);

        yield from MediaTab::make()->fields([
            MediaField::make(),
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::mediaPosition(),
            LayoutField::mediaRatio(),
            LayoutField::margin(),
        ]);
    }

    public function addToContext(): array
    {
        return [];
    }

    public function renderBlockCallback(): void
    {
        wp_enqueue_style('text-media-block-css', BudService::getUrl('text-media.css'));
        wp_enqueue_script('text-media-block-js', BudService::getUrl('text-media.js'));
    }
}
