<?php

declare(strict_types=1);

namespace App\Taxonomies;

use Adeliom\HorizonTools\Taxonomies\AbstractTaxonomy;

class Test extends AbstractTaxonomy
{
    public static ?string $slug = 'test';

    public function getPostTypes(): array
    {
        return [];
    }

    public function getConfig(array $config = []): array
    {
        $config['args']= [
            'label'=> 'Test',
            'labels'=> [
                'add_new_item'=> 'Ajouter un nouvel élément',
                'edit_item'=> 'Modifier l’élément',
                'new_item'=> 'Nouvel élément',
                'view_item'=> 'Voir l’élément',
                'view_items'=> 'Voir les éléments',
                'search_items'=> 'Rechercher un élément',
                'not_found'=> 'Aucun élément trouvé',
                'not_found_in_trash'=> 'Aucun élément trouvé dans la corbeille',
                'all_items'=> 'Tous les éléments',
                'archives'=> 'Archives des éléments'
            ],
            'show_ui' => true,
            'show_in_quick_edit' => false,
            'meta_box_cb' => false, // Show meta-box in Classic Editor posts
            'show_in_rest' => false, // Show meta-box in Gutenberg Editor posts
        ];

        return parent::getConfig($config);
    }
}