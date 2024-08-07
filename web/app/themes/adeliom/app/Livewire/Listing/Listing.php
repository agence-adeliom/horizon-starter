<?php

namespace App\Livewire\Listing;

use Adeliom\HorizonTools\Database\QueryBuilder;
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

    public function mount(): void
    {
        if ($page = Request::get('pagination')) {
            if (is_numeric($page)) {
                $this->page = $page;
            }
        }
        $this->getData();
    }

    public function getData()
    {
        $qb = new QueryBuilder();
        $qb->postType($this->postType)
            ->setPage($this->page)
            ->setPerPage(1)
            ->as(BasePostViewModel::class);

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
