<?php

declare(strict_types=1);

namespace App\View\Components\Search;

use Adeliom\HorizonTools\Database\QueryBuilder;
use Adeliom\HorizonTools\Services\ClassService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GlobalPostTypeSearch extends Component
{
    public array $results = [];
    private array $searchablePostTypes = [];
    public ?string $search = null;

    public function __construct()
    {
        $this->searchablePostTypes = ClassService::getAllSearchableCustomPostTypeClasses();

        if (!empty($this->searchablePostTypes)) {
            $this->handleSearch();
        }
    }

    private function handleSearch(): void
    {
        if ($searchTerms = request('s')) {
            $this->search = $searchTerms;

            $globalIDs = [];
            $globalPostTypes = [];

            foreach ($this->searchablePostTypes as $searchablePostType) {
                if (ClassService::isPostTypeSearchableByClassName(className: $searchablePostType)) {
                    if (property_exists($searchablePostType, 'slug') && $postTypeSlug = $searchablePostType::$slug) {
                        $postTypeQueryBuilder = new QueryBuilder();
                        $globalPostTypes[] = $postTypeSlug;
                        $postTypeQueryBuilder->postType($postTypeSlug)->search($this->search);

                        $globalIDs = array_merge($globalIDs, array_column($postTypeQueryBuilder->get(), 'ID'));
                    }
                }
            }

            $globalQueryBuilder = new QueryBuilder();
            $globalQueryBuilder->postType($globalPostTypes)->whereIdIn($globalIDs);

            $this->results = $globalQueryBuilder->getPaginatedData();
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.search.global-post-type-search');
    }
}
