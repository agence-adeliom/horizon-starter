<?php

namespace App\Livewire\Listing;

use Adeliom\HorizonTools\Database\QueryBuilder;
use Adeliom\HorizonTools\Database\TaxQuery;
use Adeliom\HorizonTools\Enum\FilterTypesEnum;
use Adeliom\HorizonTools\Services\ClassService;
use Adeliom\HorizonTools\ViewModels\Post\BasePostViewModel;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Url;
use Livewire\Component;

class Listing extends Component
{
    public ?string $postType = null;

    public array $data = [];

    #[Url(as: "pagination")]
    public int $page = 1;

    #[Url(as: "filtres")]
    public $filterFields = [];

    public array $filters = [];

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

    private function initFilters()
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

                    switch ($type) {
                        case FilterTypesEnum::TAXONOMY:
                            $taxQb = new QueryBuilder();
                            $taxQb->taxonomy($value)
                                ->fetchEmptyTaxonomies(false);

                            foreach ($taxQb->get() as $term) {
                                if ($term instanceof \WP_Term) {
                                    if (!isset($this->filters[$name])) {
                                        $this->filters[$name] = [
                                            'type' => $type->value,
                                            'name' => $name,
                                            'appearance' => $appearance,
                                            'value' => $value,
                                            'choices' => [],
                                        ];
                                    }

                                    $this->filters[$name]['choices'][] = [
                                        'slug' => $term->slug,
                                        'name' => $term->name,
                                    ];
                                }
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        }
    }

    public function handleFilters()
    {
        $this->getData();
    }

    public function getData()
    {
        $qb = new QueryBuilder();

        $qb->postType($this->postType)
            ->setPage($this->page)
            ->setPerPage(12)
            ->as(BasePostViewModel::class);

        foreach ($this->filterFields as $name => $value) {
            if (!empty($value) && isset($this->filters[$name])) {
                switch ($this->filters[$name]['type']) {
                    case FilterTypesEnum::TAXONOMY->value:
                        $taxonomyName = $this->filters[$name]['value'];

                        $taxQuery = new TaxQuery();
                        $taxQuery->add($taxonomyName, [$value]);

                        $qb->addTaxQuery($taxQuery);
                        break;
                    default:
                        break;
                }
            }
        }

        $this->data = $qb->getPaginatedData(callback: function (BasePostViewModel $post) {
            return $post->toStdClass();
        });
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
        $this->getData();
    }

    public function render()
    {
        return view('livewire.listing.listing');
    }
}
