<?php

declare(strict_types=1);

namespace App\Blocks\Content;

use Adeliom\HorizonTools\Blocks\AbstractBlock;
use Adeliom\HorizonTools\Database\QueryBuilder;
use Adeliom\HorizonTools\Database\TaxQuery;
use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use Adeliom\HorizonTools\Fields\Select\TaxonomySelectField;
use Adeliom\HorizonTools\Fields\Tabs\ContentTab;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Adeliom\HorizonTools\Services\PostService;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Taxonomy;

class PostsBlock extends AbstractBlock
{
    public static ?string $slug = 'posts';
    public static ?string $title = 'Remontée d’articles [WIP]';
    public static ?string $mode = 'preview';
    public static ?string $icon = 'table-col-before';

    // Defines the maximum number of posts to be retrieved and displayed
    public const MAX_POSTS = 4;

    // Defines the post-type to be used for the block
    public const ASSOCIATED_POST_TYPE = 'post';

    // Allows to exclude certain taxonomies from the block by specifying their slugs
    public const EXCLUDED_TAXONOMIES = [];

    // Defines the number of posts to be displayed as main posts (can be 0)
    public const NUMBER_OF_FRONT_POSTS = 1;

    public const FIELD_TYPE = 'type';
    public const FIELD_TAXONOMY = 'taxonomy';
    public const VALUE_TYPE_AUTOMATIC = 'automatic';
    public const VALUE_TYPE_MANUAL = 'manual';
    public const VALUE_TYPE_TAXONOMY = 'taxonomy';
    public const FIELD_MANUAL_POSTS = 'manualPosts';

    public function getFields(): ?iterable
    {
        $maxPosts = self::MAX_POSTS;
        $taxonomies = PostService::getAllAssociatedTaxonomies(postType: self::ASSOCIATED_POST_TYPE, excluded: self::EXCLUDED_TAXONOMIES);

        $taxonomyFields = [];

        foreach ($taxonomies as $taxoSlug => $taxoName) {
            $taxonomyFields[] = Taxonomy::make($taxoName, $taxoSlug)
                ->appearance('multi_select')
                ->taxonomy($taxoSlug)
                ->conditionalLogic([
                    ConditionalLogic::where(self::FIELD_TAXONOMY, '==', $taxoSlug)
                ])
                ->required();
        }

        yield from ContentTab::make()->fields([
            UptitleField::make(),
            HeadingField::make(),
            ButtonGroup::make(__('Type de remontée'), self::FIELD_TYPE)
                ->choices([
                    self::VALUE_TYPE_AUTOMATIC => __('Automatique'),
                    self::VALUE_TYPE_TAXONOMY => __('Taxonomie'),
                    self::VALUE_TYPE_MANUAL => __('Manuelle'),
                ])
                ->helperText(
                    <<<EOF
<strong>Automatique :</strong> récupère automatiquement les $maxPosts derniers articles
<br>
<strong>Taxonomie :</strong> permet de choisir un ou plusieurs terms de taxonomie tout en permettant de sélectionner manuellement les premiers éléments
<br>
<strong>Manuelle :</strong> permet de choisir les articles à remonter et complète avec les derniers
EOF
                ),
            TaxonomySelectField::make(postType: self::ASSOCIATED_POST_TYPE, name: self::FIELD_TAXONOMY, excluded: self::EXCLUDED_TAXONOMIES)
                ->conditionalLogic([
                    ConditionalLogic::where(self::FIELD_TYPE, '==', self::VALUE_TYPE_TAXONOMY)
                ]),
            ...$taxonomyFields,
            Relationship::make(__('Articles'), self::FIELD_MANUAL_POSTS)
                ->helperText(__('Les articles sélectionnés seront affichés en premier.'))
                ->postTypes([self::ASSOCIATED_POST_TYPE])
                ->maxPosts(self::MAX_POSTS)
                ->minPosts(1)
                ->conditionalLogic([
                    ConditionalLogic::where(self::FIELD_TYPE, '==', self::VALUE_TYPE_MANUAL),
                    ConditionalLogic::where(self::FIELD_TYPE, '==', self::VALUE_TYPE_TAXONOMY)
                ]),
            ButtonField::group(),
        ]);
    }

    public function addToContext(): array
    {
        $fields = get_fields();

        $postsToDisplay = [];

        if (!empty($fields[self::FIELD_TYPE])) {
            $queryBuilder = new QueryBuilder()->postType(self::ASSOCIATED_POST_TYPE)->perPage(self::MAX_POSTS);

            switch ($fields[self::FIELD_TYPE]) {
                case self::VALUE_TYPE_AUTOMATIC:
                    $postsToDisplay = $queryBuilder->get();
                    break;
                case self::VALUE_TYPE_TAXONOMY:
                    if (!empty($fields[self::FIELD_MANUAL_POSTS])) {
                        $postsToDisplay = $fields[self::FIELD_MANUAL_POSTS];
                    }

                    if (count($postsToDisplay) < self::MAX_POSTS) {
                        $queryBuilder->perPage(self::MAX_POSTS - count($postsToDisplay));

                        if (!empty($fields[self::FIELD_TAXONOMY])) {
                            $selectedTaxonomySlug = $fields[self::FIELD_TAXONOMY];

                            if (!empty($fields[$selectedTaxonomySlug])) {
                                $taxQuery = new TaxQuery()->add($selectedTaxonomySlug, $fields[$selectedTaxonomySlug], 'term_id');
                                $queryBuilder->addTaxQuery($taxQuery);
                            }
                        }

                        $postsToDisplay = array_merge($postsToDisplay, $queryBuilder->get());
                    }
                    break;
                case self::VALUE_TYPE_MANUAL:
                    if (!empty($fields[self::FIELD_MANUAL_POSTS])) {
                        $postsToDisplay = $fields[self::FIELD_MANUAL_POSTS];
                    }

                    if (count($postsToDisplay) < self::MAX_POSTS) {
                        $queryBuilder->perPage(self::MAX_POSTS - count($postsToDisplay))
                            ->whereIdNotIn(array_column($postsToDisplay, 'ID'));

                        $postsToDisplay = array_merge($postsToDisplay, $queryBuilder->get());
                    }
                    break;
                default:
                    break;
            }
        }

        $mainPosts = [];

        if (self::NUMBER_OF_FRONT_POSTS > 0) {
            // Extract the X first posts
            $mainPosts = array_splice($postsToDisplay, 0, self::NUMBER_OF_FRONT_POSTS);
        }

        return [
            'mainPosts' => $mainPosts,
            'posts' => $postsToDisplay,
        ];
    }

    public function renderBlockCallback(): void
    {
        return;
    }
}
