<?php

declare(strict_types=1);

namespace App\PostTypes;

use Adeliom\HorizonTools\Enum\FilterTypesEnum;
use Adeliom\HorizonTools\PostTypes\AbstractPostType;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Text;

class CustomerReview extends AbstractPostType
{
    public static ?string $slug = 'customer-review';

    // Blade component used to render the card in the listing
    public static ?string $card = 'cards.card-listing';

    public const string FIELD_REVIEW = 'review';
    public const string FIELD_REVIEWER = 'reviewer';
    public const string FIELD_RATING = 'rating';
    public const string FIELD_LASTNAME = 'lastname';
    public const string FIELD_FIRSTNAME = 'firstname';
    public const string FIELD_JOB = 'job';
    public const string FIELD_AVATAR = 'avatar';

    public function getConfig(array $config = []): array
    {
        $config['args'] = [
            'label'              => 'Avis',
            'labels'             => [
                'name'               => 'Avis',
                'singular_name'      => 'Avis',
                'menu_name'          => 'Avis',
                'add_new'            => 'Ajouter un avis',
                'add_new_item'       => 'Ajouter un nouvel avis',
                'edit_item'          => 'Modifier l’avis',
                'new_item'           => 'Nouvel avis',
                'view_item'          => 'Voir l’avis',
                'view_items'         => 'Voir les avis',
                'search_items'       => 'Rechercher un avis',
                'not_found'          => 'Aucun avis trouvé',
                'not_found_in_trash' => 'Aucun avis trouvé dans la corbeille',
                'all_items'          => 'Tous les avis',
                'archives'           => 'Archives des avis',
            ],
            'menu_icon'          => 'dashicons-star-filled',
            'supports'           => [
                'title',
            ],
            'publicly_queryable' => false,
            // 'rewrite'=> ['slug'=> 'custom'],
        ];

        return parent::getConfig($config);
    }

    public function getStyle(): string
    {
        return "seamless";
    }

    public function getFields(): ?iterable
    {
        yield Group::make("Avis client", self::FIELD_REVIEW)
            ->fields([
                Number::make("Note", self::FIELD_RATING)
                    ->helperText("Note attribuée à l'avis entre 0 et 5, par pas de 0.5")
                    ->min(0)
                    ->max(5)
                    ->step(0.5)
                    ->required(),
                Text::make("Avis", self::FIELD_REVIEW)
                    ->required(),
            ]);

        yield Group::make("Information client", self::FIELD_REVIEWER)
            ->fields([
                Text::make("Nom", self::FIELD_LASTNAME)
                    ->required(),
                Text::make("Prénom", self::FIELD_FIRSTNAME)
                    ->required(),
                Text::make("Fonction", self::FIELD_JOB)
                    ->required(),
                Image::make("Photo", self::FIELD_AVATAR)
                    ->helperText("Si aucune photo n'est renseignée, les initiales du nom et prénom seront affichées."),
            ]);
    }

    /**
     * Allow to set filters that will be used inside generic listings
     * @return array
     */
    public function getFilters(): array
    {
        return [
            [
                'name' => 'rating', // Name of the filter field in the filter form
                'type' => FilterTypesEnum::META, // Filter type (taxonomy or meta)
                'appearance' => 'select', // Appearance of the filter (only select supported)
                'value' => sprintf('%s_%s', self::FIELD_REVIEW, self::FIELD_RATING), // Full name of the meta field (be careful if in groups for instance)
                'fieldClass' => Number::class,
                'placeholder' => 'Note' // Placeholder of the field (or label of "all" options)
            ],
        ];
    }
}
