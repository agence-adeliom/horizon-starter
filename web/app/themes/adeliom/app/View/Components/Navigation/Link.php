<?php

declare(strict_types=1);

namespace App\View\Components\Navigation;

use App\Fields\Links\LinkField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class Link extends Component
{
    private readonly string $type;
    public ?stdClass $icon = null;
    public ?string $title = null;
    public ?string $url = null;
    public ?string $target = null;
    private readonly \WP_Post $post;

    public function __construct(private readonly array $fields)
    {
        $this->handleFields();
    }

    private function handleFields(): void
    {
        if (isset($this->fields[LinkField::FIELD_TYPE])) {
            $this->type = $this->fields[LinkField::FIELD_TYPE];

            switch ($this->type) {
                case LinkField::VALUE_TYPE_INTERNAL:
                    if (isset($this->fields[LinkField::FIELD_POST])) {
                        $this->post = $this->fields[LinkField::FIELD_POST];
                        $this->url = get_permalink($this->fields[LinkField::FIELD_POST]);
                    }

                    if (isset($this->fields[LinkField::FIELD_POST_LABEL]) && $this->fields[LinkField::FIELD_POST_LABEL]) {
                        $this->title = $this->fields[LinkField::FIELD_POST_LABEL];
                    } else {
                        $this->title = $this->post->post_title;
                    }

                    if (isset($this->fields[LinkField::FIELD_IS_TARGET_BLANK]) && $this->fields[LinkField::FIELD_IS_TARGET_BLANK]) {
                        $this->target = "_blank";
                    }
                    break;
                case LinkField::VALUE_TYPE_EXTERNAL:
                    if (isset($this->fields[LinkField::FIELD_EXTERNAL_LINK])) {
                        $link = $this->fields[LinkField::FIELD_EXTERNAL_LINK];

                        if (isset($link['title'])) {
                            $this->title = $link['title'];
                        }

                        if (isset($link['url'])) {
                            $this->url = $link['url'];
                        }

                        if (!empty($link['target'])) {
                            $this->target = $link['target'];
                        }
                    }
                    break;
                default:
                    break;
            }

            if (isset($this->fields[LinkField::FIELD_ICON])) {
                $this->icon = $this->fields[LinkField::FIELD_ICON];
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.navigation.link');
    }
}
