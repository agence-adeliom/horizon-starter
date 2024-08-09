<?php

namespace App\Livewire\Listing;

use Adeliom\HorizonTools\Database\MetaQuery;
use Adeliom\HorizonTools\Database\QueryBuilder;
use Adeliom\HorizonTools\Database\TaxQuery;
use Adeliom\HorizonTools\Enum\FilterTypesEnum;
use Adeliom\HorizonTools\Services\AcfService;
use Adeliom\HorizonTools\Services\ClassService;
use Adeliom\HorizonTools\ViewModels\Post\BasePostViewModel;
use Extended\ACF\Fields\Select;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Url;
use Livewire\Component;

class Listing extends Component
{
    private const DEFAULT_ORDER = 'date.DESC';

    public ?string $postType = null;

    public array $data = [];

    #[Url(as: "pagination")]
    public int $page = 1;
    #[Url(as: "filtres")]
    public array $filterFields = [];
    #[Url(as: "tri")]
    public string $order = self::DEFAULT_ORDER;
    public int $perPage = 12;

    public array $filters = [];

    public array $sortOptions = [
        'date.DESC' => 'Plus récent',
        'date.ASC' => 'Plus ancien',
    ];

    public function mount(): void
    {
        $this->initFilters();

        if ($page = Request::get('pagination')) {
            if (is_numeric($page)) {
                $this->page = $page;
            }
        }
        $this->getData();
    }

    private function initTaxonomyFilter(string $taxonomyName, string $filterName, FilterTypesEnum $filterType, string $appearance, string $placeholder): void
    {
        $taxQb = new QueryBuilder();
        $taxQb->taxonomy($taxonomyName)
            ->fetchEmptyTaxonomies(false);

        foreach ($taxQb->get() as $term) {
            if ($term instanceof \WP_Term) {
                if (!isset($this->filters[$filterName])) {
                    $this->filters[$filterName] = [
                        'type' => $filterType->value,
                        'name' => $filterName,
                        'appearance' => $appearance,
                        'value' => $taxonomyName,
                        'placeholder' => $placeholder,
                        'choices' => [],
                    ];
                }

                $this->filters[$filterName]['choices'][] = [
                    'slug' => $term->slug,
                    'name' => $term->name,
                ];
            }
        }
    }

    private function initMetaFilter(string $metaKey, string $filterName, FilterTypesEnum $filterType, string $appearance, string $postType, string $fieldClass, string $placeholder): void
    {
        global $wpdb;

        $query = <<<EOF
        SELECT DISTINCT meta_value AS value
        FROM {$wpdb->postmeta}
        JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
        WHERE meta_key = %s AND post_type = %s AND post_status = 'publish'
        EOF;

        $query = $wpdb->prepare($query, $metaKey, $postType::$slug);

        $results = $wpdb->get_results($query);

        // Convert to array of values
        $values = array_map(function ($result) {
            return $result->value;
        }, $results);

        switch ($fieldClass) {
            case Select::class:
                $postTypeInstance = new $postType();
                if ($choices = AcfService::getChoices($postTypeInstance->getFields(), $metaKey)) {
                    if (!isset($this->filters[$filterName])) {
                        $this->filters[$filterName] = [
                            'type' => $filterType->value,
                            'name' => $filterName,
                            'appearance' => $appearance,
                            'value' => $metaKey,
                            'placeholder' => $placeholder,
                            'choices' => [],
                        ];
                    }
                    foreach ($choices as $value => $label) {
                        $this->filters[$filterName]['choices'][] = [
                            'slug' => $value,
                            'name' => $label,
                        ];
                    }
                }
                break;
            default:
                foreach ($values as $value) {
                    if (!empty($value)) {
                        if (!isset($this->filters[$filterName])) {
                            $this->filters[$filterName] = [
                                'type' => $filterType->value,
                                'name' => $filterName,
                                'appearance' => $appearance,
                                'value' => $metaKey,
                                'placeholder' => $placeholder,
                                'choices' => [],
                            ];
                        }

                        $this->filters[$filterName]['choices'][] = [
                            'slug' => $value,
                            'name' => $value,
                        ];
                    }
                }
                break;
        }
    }

    private function initFilters(): void
    {
        if ($postTypeClass = ClassService::getPostTypeClassBySlug($this->postType)) {
            $classInstance = new $postTypeClass();

            if (method_exists($classInstance, 'getFilters')) {
                foreach ($classInstance->getFilters() as $filter) {
                    if (!isset($filter['type'], $filter['appearance'], $filter['value'])) {
                        throw new \Exception("Filter must have a type, appearance and value");
                    }

                    $type = $filter['type'];
                    $appearance = $filter['appearance'];
                    $value = $filter['value'];
                    $name = $filter['name'] ?? $value;
                    $placeholder = $filter['placeholder'] ?? 'Filtre';

                    switch ($type) {
                        case FilterTypesEnum::TAXONOMY:
                            $this->initTaxonomyFilter(taxonomyName: $value, filterName: $name, filterType: $type, appearance: $appearance, placeholder: $placeholder);
                            break;
                        case FilterTypesEnum::META:
                            $fieldClass = $filter['fieldClass'];
                            $this->initMetaFilter(metaKey: $value, filterName: $name, filterType: $type, appearance: $appearance, postType: $postTypeClass, fieldClass: $fieldClass, placeholder: $placeholder);
                            break;
                        default:
                            break;
                    }
                }
            }
        }
    }

    public function handleFilters(): void
    {
        $this->getData();
    }

    public function getData(): void
    {
        $qb = new QueryBuilder();

        $qb->postType($this->postType)
            ->setPage($this->page)
            ->setPerPage($this->perPage)
            ->as(BasePostViewModel::class);

        if (is_array($this->filterFields)) {
            foreach ($this->filterFields as $name => $value) {
                if (!empty($value) && isset($this->filters[$name])) {
                    switch ($this->filters[$name]['type']) {
                        case FilterTypesEnum::TAXONOMY->value:
                            $taxonomyName = $this->filters[$name]['value'];

                            $taxQuery = new TaxQuery();
                            $taxQuery->add($taxonomyName, [$value]);

                            $qb->addTaxQuery($taxQuery);
                            break;
                        case FilterTypesEnum::META->value:
                            $metaName = $this->filters[$name]['value'];

                            $metaQuery = new MetaQuery();
                            $metaQuery->add($metaName, $value);

                            $qb->addMetaQuery($metaQuery);
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        if ($this->order) {
            [$orderBy, $order] = explode('.', $this->order);

            switch ($orderBy) {
                case 'date':
                    $qb->orderBy($order, $orderBy);
                    break;
                default:
                    // TODO Handle meta fields
                    break;
            }
        }

        $this->data = $qb->getPaginatedData(callback: function (BasePostViewModel $post) {
            return $post->toStdClass();
        });

        if ($this->data['current'] > $this->data['pages'] || null === $this->data['pages']) {
            $this->page = 1;
        }
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
        $this->getData();
    }

    public function resetFilters(): void
    {
        $this->page = 1;
        $this->order = self::DEFAULT_ORDER;

        foreach ($this->filterFields as $key => $filterField) {
            $this->filterFields[$key] = null;
        }

        $this->dispatch('filters-reset');

        $this->getData();
    }

    public function render()
    {
        return view('livewire.listing.listing');
    }
}
