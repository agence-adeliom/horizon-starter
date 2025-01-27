<?php

declare(strict_types=1);

namespace App\View\Components\Navigation;

use Adeliom\HorizonTools\Fields\Buttons\ButtonField;
use App\Admin\OptionPageAdmin;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopNavigation extends Component
{
    private ?array $fields = null;
    public ?string $containerClass = null;
    public bool $enabled = false;
    public bool $withReviews = false;
    public bool $withReviewsLink = false;
    public ?array $allReviewsLink = null;
    private ?string $reviewsType = null;
    public ?array $links = null;
    public bool $withSearch = false;
    public ?array $searchInfos = null;
    public ?float $reviewsAverage = null;

    public function __construct()
    {
        $this->retrieveFields();
        $this->handleFields();
        $this->handleContainerClass();
    }

    private function handleReviews(): void
    {
        if ($this->withReviews) {
            if ($reviewsFields = get_field(OptionPageAdmin::FIELD_REVIEWS_FIELDS, 'option')) {
                if (isset($reviewsFields[OptionPageAdmin::FIELD_GLOBAL_RATING])) {
                    $this->reviewsAverage = floatval($reviewsFields[OptionPageAdmin::FIELD_GLOBAL_RATING]);
                }

                if ($this->withReviewsLink) {
                    if (isset($reviewsFields[OptionPageAdmin::FIELD_BTN_REVIEWS])) {
                        if (isset($reviewsFields[OptionPageAdmin::FIELD_BTN_REVIEWS][ButtonField::BUTTON_LINK])) {
                            $linkArray = $reviewsFields[OptionPageAdmin::FIELD_BTN_REVIEWS];
                            if (isset($this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_REVIEWS_LINK_LABEL])) {
                                $linkArray[ButtonField::BUTTON_LINK]['title'] = $this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_REVIEWS_LINK_LABEL];
                            }
                            $this->allReviewsLink = $linkArray;
                            /*  dump($linkArray);

                            if (isset($linkArray['url'])) {
                                $this->allReviewsLink = $linkArray['url'];

                                if (isset($this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_REVIEWS_LINK_LABEL])) {
                                    $this->allReviewsLabel = $this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_REVIEWS_LINK_LABEL];
                                } elseif (isset($linkArray['title'])) {
                                    $this->allReviewsLabel = $linkArray['title'];
                                }
                            } */
                        }
                    }
                }
            }
        }
    }

    private function handleContainerClass(): void
    {
        $classes = ['flex flex-col gap-8 container lg:flex-row'];

        if ($this->withReviews) {
            $classes[] = 'lg:justify-between';
        } else {
            $classes[] = 'lg:justify-end';
        }

        $this->containerClass = implode(' ', $classes);
    }

    private function handleFields(): void
    {
        if (null !== $this->fields) {
            if (isset($this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_REVIEWS_TYPE])) {
                $this->reviewsType = $this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_REVIEWS_TYPE];

                if (isset($this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_SHOW_SEARCH]) && $this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_SHOW_SEARCH]) {
                    $this->withSearch = true;
                    if (isset($this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_SEARCH_INFOS])) {
                        $this->searchInfos = $this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_SEARCH_INFOS];
                    }
                }

                switch ($this->reviewsType) {
                    case OptionPageAdmin::VALUE_TOP_NAVIGATION_REVIEWS_TYPE_DEFAULT:
                        $this->withReviews = true;
                        $this->handleReviews();
                        break;
                    case OptionPageAdmin::VALUE_TOP_NAVIGATION_REVIEWS_TYPE_DEFAULT_WITH_LINK:
                        $this->withReviews = true;
                        $this->withReviewsLink = true;
                        $this->handleReviews();
                        break;
                    default:
                        break;
                }
            }

            if (isset($this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_LINKS_REPEATER])) {
                if (is_array($this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_LINKS_REPEATER])) {
                    foreach ($this->fields[OptionPageAdmin::FIELD_TOP_NAVIGATION_LINKS_REPEATER] as $linkData) {
                        if (isset($linkData[OptionPageAdmin::FIELD_TOP_NAVIGATION_LINK])) {
                            $linkFields = $linkData[OptionPageAdmin::FIELD_TOP_NAVIGATION_LINK];

                            if (null === $this->links) {
                                $this->links = [];
                            }

                            $this->links[] = $linkFields;
                        }
                    }
                }
            }
        }
    }

    private function retrieveFields(): void
    {
        if ($topNavigationFields = get_field(OptionPageAdmin::FIELD_TOP_NAVIGATION, 'option')) {
            if (isset($topNavigationFields[OptionPageAdmin::FIELD_TOP_NAVIGATION_ENABLED]) && $topNavigationFields[OptionPageAdmin::FIELD_TOP_NAVIGATION_ENABLED]) {
                $this->enabled = true;
                $this->fields = $topNavigationFields;
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.navigation.top-navigation');
    }
}
