<?php

declare(strict_types=1);

namespace App\Livewire\Listing;

use Adeliom\HorizonTools\Admin\SearchEngineOptionsAdmin;
use Adeliom\HorizonTools\Services\SearchEngineService;
use Adeliom\HorizonTools\Services\SeoService;
use Illuminate\View\View;
use Livewire\Component;

class SearchEngineResults extends Component
{
    public array $types = [];
    public int $perPage = 12;
    public int|array $page = 1;
    public bool $separateResultsByType = false;
    public bool $displayTypeFilters = false;
    public bool $displayBreadcrumbs = false;
    public array $results = [];
    public array $typeChoices = [];
    public string $typeChoice = self::VALUE_ALL_TYPE;
    public array $resultsPerType = [];
    public array $typesToFetch = [];
    public ?string $searchQuery = '';
    public ?string $headerTitle = null;
    public ?array $headerImage = null;
    public ?array $foundPostTypes = [];

    private readonly array $searchConfig;

    public const VALUE_ALL_TYPE = 'all';

    public function mount(): void
    {
        $this->triggerChange();
    }

    public function updated(): void
    {
        $this->triggerChange();
    }

    /**
     * Updates the meta-title based on the search query.
     */
    public function updatedSearchQuery(): void
    {
        if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_META_TITLE])) {
            $baseMetaTitle = $this->searchConfig[SearchEngineOptionsAdmin::FIELD_META_TITLE];

            if (str_contains($baseMetaTitle, SearchEngineOptionsAdmin::SEARCH_PLACEHOLDER)) {
                $baseMetaTitle = str_replace(SearchEngineOptionsAdmin::SEARCH_PLACEHOLDER, $this->searchQuery, $baseMetaTitle);
                $baseMetaTitle = sprintf('%s %s', $baseMetaTitle, SeoService::getMetaTitleSuffix());

                $this->dispatch('setMetaTitle', [
                    'title' => $baseMetaTitle,
                ]);
            }
        }
    }

    /**
     * Runs the necessary methods to reinitialize the component's data
     */
    public function triggerChange(): void
    {
        if (is_admin()) {
            // Here to display results in the Gutenberg editor by default
            $this->searchQuery = 'a';
        }

        $this->searchConfig = SearchEngineService::getSearchEngineConfig();

        $this->initConfig();
        $this->initData();
        $this->fetchData();
    }

    /**
     * Sets the search query and triggers a re-fetch of the results.
     */
    public function setPage(int $page, ?string $postType = null): void
    {
        $hasChanged = false;

        if (null === $postType) {
            $this->page = $page;
            $hasChanged = true;
        } else {
            if (isset($this->page[$postType])) {
                $this->page[$postType] = $page;
                $hasChanged = true;
            }
        }

        if ($hasChanged) {
            $this->triggerChange();
        }
    }

    protected function queryString(): array
    {
        return [
            'searchQuery' => [
                'as' => $this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_GET_PARAMETER] ?? 'recherche',
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

    /**
     * Initializes the configuration based on the search engine settings.
     */
    private function initConfig(): void
    {
        if ($this->searchConfig) {
            if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_PER_PAGE])) {
                if (is_numeric($this->searchConfig[SearchEngineOptionsAdmin::FIELD_PER_PAGE])) {
                    $this->perPage = (int)$this->searchConfig[SearchEngineOptionsAdmin::FIELD_PER_PAGE];
                }
            }

            if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_TYPES])) {
                if (is_array($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_TYPES])) {
                    $this->types = $this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_TYPES];
                    $this->typesToFetch = $this->types;
                }
            }

            if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEPARATE_BY_TYPES])) {
                if (is_bool($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEPARATE_BY_TYPES])) {
                    $this->separateResultsByType = $this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEPARATE_BY_TYPES];
                }
            }

            if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_GET_PARAMETER])) {
                if (is_string($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_GET_PARAMETER])) {
                    $this->searchParam = $this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_GET_PARAMETER];
                }
            }

            if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_ALLOW_FILTER_BY_TYPE])) {
                if (is_bool($this->searchConfig[SearchEngineOptionsAdmin::FIELD_ALLOW_FILTER_BY_TYPE])) {
                    $this->displayTypeFilters = $this->searchConfig[SearchEngineOptionsAdmin::FIELD_ALLOW_FILTER_BY_TYPE];
                }
            }

            if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_HEADER_TITLE])) {
                $baseTitle = $this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_HEADER_TITLE];

                if (str_contains($baseTitle, SearchEngineOptionsAdmin::SEARCH_PLACEHOLDER)) {
                    $this->headerTitle = str_replace(SearchEngineOptionsAdmin::SEARCH_PLACEHOLDER, $this->searchQuery, $baseTitle);
                }
            }

            if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_HEADER_HAS_BREADCRUMBS])) {
                if (is_bool($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_HEADER_HAS_BREADCRUMBS])) {
                    $this->displayBreadcrumbs = $this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_HEADER_HAS_BREADCRUMBS];
                }
            }

            if (!empty($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_HEADER_IMAGE])) {
                if (is_array($this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_HEADER_IMAGE])) {
                    $this->headerImage = $this->searchConfig[SearchEngineOptionsAdmin::FIELD_SEARCH_HEADER_IMAGE];
                }
            }
        }

        if ($this->separateResultsByType && is_int($this->page)) {
            $this->page = [];

            foreach ($this->types as $type) {
                $this->page[$type] = 1;
            }
        } elseif (!$this->separateResultsByType && is_array($this->page)) {
            $this->page = 1;
        }
    }

    /**
     * Initializes the data for the component, including type choices and results to fetch.
     */
    private function initData(): void
    {
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

        if (!$this->separateResultsByType) {
            if ($this->displayTypeFilters && $this->typeChoice !== self::VALUE_ALL_TYPE && in_array($this->typeChoice, $this->types)) {
                $this->typesToFetch = [$this->typeChoice];
            } else {
                $this->typesToFetch = $this->types;
            }
        } else {
            foreach ($this->page as $postTypeSlug => $page) {
                if (is_numeric($page)) {
                    $page = intval($page);
                }

                $this->page[$postTypeSlug] = $page;
            }
        }
    }

    private function fetchData(): void
    {
        $this->foundPostTypes = [];

        $this->results = $this->getResults(foundPostTypes: $this->foundPostTypes);

        $this->handleTypeChoices();
        $this->handlePageReset();
    }

    private function handleTypeChoices(): void
    {
        if ($this->separateResultsByType) {
            foreach ($this->typeChoices as $typeSlug => $typeChoice) {
                if ($typeSlug !== self::VALUE_ALL_TYPE) {
                    if (empty($this->results[$typeSlug])) {
                        unset($this->typeChoices[$typeSlug]);

                        if ($this->typeChoice === $typeSlug) {
                            $this->typeChoice = self::VALUE_ALL_TYPE;
                        }
                    }
                }
            }
        } else {
            foreach ($this->typeChoices as $typeSlug => $typeChoice) {
                if ($typeSlug !== self::VALUE_ALL_TYPE && $typeSlug === $this->typeChoice) {
                    if (!in_array($this->typeChoice, $this->foundPostTypes)) {
                        $this->typeChoice = self::VALUE_ALL_TYPE;
                    }
                }
            }
        }
    }

    /**
     * Fetches the search results based on the current configuration.
     */
    private function getResults(array &$foundPostTypes = []): array
    {
        if (empty($this->searchQuery)) {
            return [];
        }

        return SearchEngineService::searchPostTypes(postTypes: $this->types, onlyGetResultsFromPostTypes: $this->typesToFetch, query: $this->searchQuery, separateResultsByType: $this->separateResultsByType, page: $this->page, perPage: $this->perPage, foundPostTypes: $foundPostTypes);
    }

    /**
     * Handles the reset of the page number when there are no results.
     */
    private function handlePageReset(): void
    {
        if (!$this->separateResultsByType) {
            if (isset($this->results['total']) && $this->results['total'] === 0) {
                $this->setPage(1);
            }
        } else {
            foreach ($this->results as $postTypeSlug => $postTypeData) {
                $postTypeData['extraHandleParams'] = [$postTypeSlug];

                $this->results[$postTypeSlug] = $postTypeData;

                if (!empty($this->results[$postTypeSlug]) && $this->results[$postTypeSlug]['total'] === 0) {
                    $this->setPage(1, $postTypeSlug);
                }
            }
        }
    }

    public function render(): View
    {
        return view('livewire.listing.search-engine-results');
    }
}
