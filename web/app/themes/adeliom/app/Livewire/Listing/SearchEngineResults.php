<?php

namespace App\Livewire\Listing;

use Adeliom\HorizonTools\Admin\SearchEngineOptionsAdmin;
use Adeliom\HorizonTools\Database\QueryBuilder;
use Adeliom\HorizonTools\Services\SearchEngineService;
use Adeliom\HorizonTools\ViewModels\Post\BasePostViewModel;
use Livewire\Component;

class SearchEngineResults extends Component
{
    public array $types = [];
    public int $perPage = 12;
    public int $page = 1;
    public bool $separateResultsByType = false;
    public array $results = [];
    public array $typeChoices = [];
    public string $typeChoice = self::VALUE_ALL_TYPE;
    public array $resultsPerType = [];
    public array $typesToFetch = [];
    public ?string $searchQuery = '';

    private const VALUE_ALL_TYPE = 'all';

    public function mount(): void
    {
        $this->initConfig();
        $this->initData();
        $this->fetchData();
    }

    public function updated(): void
    {
        $this->initConfig();
        $this->initData();
        $this->fetchData();
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

            if ($this->typeChoice !== self::VALUE_ALL_TYPE && in_array($this->typeChoice, $this->types)) {
                $this->typesToFetch = [$this->typeChoice];
            } else {
                $this->typesToFetch = $this->types;
            }
        }
    }

    private function fetchData(): void
    {
        switch (true) {
            case $this->separateResultsByType:
                foreach ($this->types as $type) {
                    $this->fetchDataByType(type: $type);
                }
                break;
            default:
                $this->fetchAllData();
                break;
        }
    }

    private function getBaseSearchQueryBuilder(): QueryBuilder
    {
        $qb = new QueryBuilder();
        $qb->page($this->page)->perPage($this->perPage)->search($this->searchQuery);

        if ($searchPage = SearchEngineService::getSearchEngineResultsPage()) {
            $qb->whereIdNotIn($searchPage->ID);
        }

        return $qb;
    }

    private function fetchAllData(): void
    {
        $qb = $this->getBaseSearchQueryBuilder()->postType($this->typesToFetch)->as(BasePostViewModel::class);

        $this->results = $qb->getPaginatedData(callback: function (BasePostViewModel $result) {
            return $result->toStdClass();
        });
    }

    private function fetchDataByType(string $type): void
    {

    }

    public function render()
    {
        return view('livewire.listing.search-engine-results');
    }
}
