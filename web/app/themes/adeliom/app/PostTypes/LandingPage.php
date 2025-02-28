<?php

declare(strict_types=1);

namespace App\PostTypes;

use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\PostTypes\AbstractPostType;

class LandingPage extends AbstractPostType
{
    public static ?string $slug = 'landing-page';
    public static bool $searchable = true;

    // Blade component used to render the card in the listing
    public static ?string $card = 'cards.card-listing';

    public const string BTN_HIGHLIGHT = "btn-highlight";

    public function getConfig(array $config = []): array
    {
        $config['args'] = [
            'label'     => 'LandingPage',
            'labels'    => [
                'name'               => 'Landing page',
                'singular_name'      => 'Landing page',
                'menu_name'          => 'Landing page',
                'add_new'            => 'Ajouter un élément',
                'add_new_item'       => 'Ajouter un nouvel élément',
                'edit_item'          => 'Modifier l’élément',
                'new_item'           => 'Nouvel élément',
                'view_item'          => 'Voir l’élément',
                'view_items'         => 'Voir les éléments',
                'search_items'       => 'Rechercher un élément',
                'not_found'          => 'Aucun élément trouvé',
                'not_found_in_trash' => 'Aucun élément trouvé dans la corbeille',
                'all_items'          => 'Tous les éléments',
                'archives'           => 'Archives des éléments',
            ],
            'menu_icon' => 'dashicons-admin-post',
            'supports'  => [
                'title',
                'editor',
            ],
            // 'rewrite'=> ['slug'=> 'custom'],
        ];

        return parent::getConfig($config);
    }

    public function getFields(): ?iterable
    {
        yield ButtonField::make("Bouton principal", self::BTN_HIGHLIGHT);
    }

    public function getPosition(): string
    {
        return 'side';
    }

    /**
     * Allow to set filters that will be used inside generic listings
     *
     * @return array
     */
    public function getFilters(): array
    {
        // return [
        //     [
        //         'name' => 'fieldname',
        //         'type' => FilterTypesEnum::TAXONOMY,
        //         'appearance' => 'select',
        //         'value' => 'tested value', // could be taxonomy slug or meta key
        //     ],
        // ];

        return [];
    }
}
