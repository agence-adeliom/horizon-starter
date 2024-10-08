<?php

declare(strict_types=1);

namespace App\Blocks\Reassurance;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Tabs\LayoutTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;
use Adeliom\HorizonTools\Services\BudService;
use App\Admin\OptionPageAdmin;
use App\PostTypes\CustomerReview;
use Extended\ACF\Fields\Message;
use Extended\ACF\Fields\Relationship;

class CustomerReviewBlock extends AbstractBlock
{

    public const string FIELD_REVIEWS = 'reviews';
    public static ?string $slug = 'customer-review';
    public static ?string $title = 'Avis clients';
    public static ?string $description = 'Affiche une série de témoignages clients, ainsi que la note globale attribuée.';

    public function getFields(): ?iterable
    {
        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make()->required(),
            WysiwygField::default(),
            Message::make("Information")
                ->body("La note globale est gérée au niveau général de votre thème."),
            Relationship::make("Avis clients", self::FIELD_REVIEWS)
                ->minPosts(2)
                ->maxPosts(3)
                ->postTypes([CustomerReview::$slug])->required(),
        ]);

        yield from LayoutTab::make()->fields([
            LayoutField::margin(),
        ]);
    }

    public function addToContext(): array
    {
        $options = get_field(OptionPageAdmin::FIELDS_REVIEWS, 'option');
        $globalRating = $options[OptionPageAdmin::GLOBAL_RATING] ?? null;
        $btnRating = $options[OptionPageAdmin::BTN_REVIEWS] ?? null;

        return [
            OptionPageAdmin::GLOBAL_RATING => $globalRating,
            OptionPageAdmin::BTN_REVIEWS   => $btnRating,
        ];
    }

    public function renderBlockCallback(): void
    {
        wp_enqueue_script('customer-review-block-js', BudService::getUrl('customer-review.js'));
    }
}
