<?php

declare(strict_types=1);

namespace App\View\Components\Search;

use Adeliom\HorizonTools\Database\QueryBuilder;
use Adeliom\HorizonTools\Services\ClassService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SinglePostTypeSearch extends Component
{
    public array $results = [];
    public ?string $search = null;
    public ?string $postTypeName = null;

    public function __construct(private readonly string $postTypeClass)
    {
        if(!ClassService::isPostTypeSearchableByClassName(className: $this->postTypeClass)){
            throw new \Exception(sprintf('The post type %s is not searchable', $this->postTypeClass));
        }

        $this->handleSearch();
    }

    private function handleSearch():void
    {
        if($searchTerms = request('s')) {
            $this->search = $searchTerms;

            $instance = new $this->postTypeClass();

            if(method_exists($instance,'getConfig')&& $config = $instance->getConfig()){
                $this->postTypeName = $config['args']['label']??null;
            }

            if(property_exists($this->postTypeClass, 'slug')&&$this->postTypeClass::$slug){
                $qb = new QueryBuilder();
                $qb->postType($this->postTypeClass::$slug)->search($searchTerms);

                $this->results = $qb->getPaginatedData();
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.search.single-post-type-search');
    }
}
