<?php

declare(strict_types=1);

namespace App\Livewire\Listing;

use Adeliom\HorizonTools\Admin\SearchEngineOptionsAdmin;
use Adeliom\HorizonTools\Services\SearchEngineService;
use Livewire\Component;

class SearchEngineResults extends Component
{
    public array $types = [];
    public int $perPage = 12;
    public int $page = 1;
    public bool $separateResultsByType = false;
    public bool $displayTypeFilters = false;
    public array $results = [];
    public array $typeChoices = [];
    public string $typeChoice = self::VALUE_ALL_TYPE;
    public array $resultsPerType = [];
    public array $typesToFetch = [];
    public ?string $searchQuery = '';

    private const VALUE_ALL_TYPE = 'all';

    public function mount(): void
    {
        $this->triggerChange();
    }

    public function updated(): void
    {
        $this->triggerChange();
    }

    public function triggerChange(): void
    {
        $this->initConfig();
        $this->initData();
        $this->fetchData();
    }

    public function setPage(int $page, ?string $postType = null): void
    {
        $hasChanged = false;

        if (null === $postType) {
            $this->page = $page;
            $hasChanged = true;
        } else {

        }

        if ($hasChanged) {
            $this->triggerChange();
        }
    }

    private function getPostTypePaginationKey(string $postTypeSlug): string
    {
        // convert to camelCase with - and _ handling
        $key = str_replace(['-', '_'], '', ucwords($postTypeSlug, '-_'));

        return sprintf('pagination%s', $key);
    }

    protected function queryString(): array
    {
        return [
            'searchQuery' => [
                'as' => SearchEngineService::getSearchEngineConfig()[SearchEngineOptionsAdmin::FIELD_SEARCH_GET_PARAMETER] ?? 'recherche',
            ],
            'page' => [
                'as' => 'pagination',
                'except' => '1',
            ],
            'typeChoice' => [
                'as' => 'type',
                'except' => self::VALUE_ALL_TYPE,
            ]
        ];
    }

    private function initConfig(): void
    {
        if ($config = SearchEngineService::getSearchEngineConfig()) {
            if (!empty($config[SearchEngineOptionsAdmin::FIELD_PER_PAGE])) {
                if (is_numeric($config[SearchEngineOptionsAdmin::FIELD_PER_PAGE])) {
                    $this->perPage = (int)$config[SearchEngineOptionsAdmin::FIELD_PER_PAGE];
                }
            }

            if (!empty($config[SearchEngineOptionsAdmin::FIELD_SEARCH_TYPES])) {
                if (is_array($config[SearchEngineOptionsAdmin::FIELD_SEARCH_TYPES])) {
                    $this->types = $config[SearchEngineOptionsAdmin::FIELD_SEARCH_TYPES];
                    $this->typesToFetch = $this->types;
                }
            }

            if (!empty($config[SearchEngineOptionsAdmin::FIELD_SEPARATE_BY_TYPES])) {
                if (is_bool($config[SearchEngineOptionsAdmin::FIELD_SEPARATE_BY_TYPES])) {
                    $this->separateResultsByType = $config[SearchEngineOptionsAdmin::FIELD_SEPARATE_BY_TYPES];
                }
            }

            if (!empty($config[SearchEngineOptionsAdmin::FIELD_SEARCH_GET_PARAMETER])) {
                if (is_string($config[SearchEngineOptionsAdmin::FIELD_SEARCH_GET_PARAMETER])) {
                    $this->searchParam = $config[SearchEngineOptionsAdmin::FIELD_SEARCH_GET_PARAMETER];
                }
            }

            if (!empty($config[SearchEngineOptionsAdmin::FIELD_ALLOW_FILTER_BY_TYPE])) {
                if (is_bool($config[SearchEngineOptionsAdmin::FIELD_ALLOW_FILTER_BY_TYPE])) {
                    $this->displayTypeFilters = $config[SearchEngineOptionsAdmin::FIELD_ALLOW_FILTER_BY_TYPE];
                }
            }
        }
    }

    private function initData(): void
    {
        if (!$this->separateResultsByType) {
            $this->typeChoices[self::VALUE_ALL_TYPE] = 'Tous les résultats';

            foreach ($this->types as $typeSlug) {
                $label = null;

                switch ($typeSlug) {
                    case 'post':
                        $label = 'Articles';
                        break;
                    case 'page':
                        $label = 'Pages';
                        break;
                    default:
                        if ($postTypeObject = get_post_type_object($typeSlug)) {
                            $label = $postTypeObject->labels->name ?? null;
                        }
                        break;
                }

                if ($label) {
                    $this->typeChoices[$typeSlug] = $label;
                }
            }

            if ($this->displayTypeFilters && $this->typeChoice !== self::VALUE_ALL_TYPE && in_array($this->typeChoice, $this->types)) {
                $this->typesToFetch = [$this->typeChoice];
            } else {
                $this->typesToFetch = $this->types;
            }
        }
    }

    private function fetchData(): void
    {
        $this->results = SearchEngineService::searchPostTypes(postTypes: $this->typesToFetch, query: $this->searchQuery, separateResultsByType: $this->separateResultsByType, page: $this->page, perPage: $this->perPage);

        if (!$this->separateResultsByType) {
            if (isset($this->results['total']) && $this->results['total'] === 0) {
                $this->setPage(1);
            }
        } else {
            foreach ($this->results as $postTypeSlug => $postTypeData) {
                $postTypeData['extraHandleParams'] = [$postTypeSlug];

                $this->results[$postTypeSlug] = $postTypeData;
            }
        }
    }

    public function render()
    {
        return view('livewire.listing.search-engine-results');
    }
}
