<?php

namespace App\View\Components\Content;

use Adeliom\HorizonTools\Fields\Layout\LayoutField;
use Adeliom\HorizonTools\Fields\Medias\MediaField;
use Adeliom\HorizonTools\Fields\Medias\VideoField;
use Adeliom\HorizonTools\Fields\Text\HeadingField;
use Adeliom\HorizonTools\Fields\Text\UptitleField;
use Adeliom\HorizonTools\Fields\Text\WysiwygField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextMedia extends Component
{
    private const MEDIA_POSITIONS = ['left', 'right'];
    private const MEDIA_RATIOS = ['auto', 'paysage', 'portrait'];

    private const POSITIONS = [
        'portrait' => [
            'right' => [
                'text' => 'lg:row-start-1 lg:col-span-6',
                'media' => 'max-lg:order-1 lg:col-start-8 lg:col-end-13',
            ],
            'left' => [
                'text' => 'lg:col-start-7 lg:col-end-13',
                'media' => 'lg:col-start-1 lg:col-end-6',
            ],
        ],
        'paysage' => [
            'right' => [
                'text' => 'lg:row-start-1 lg:col-span-5',
                'media' => 'lg:col-start-7 lg:col-end-13',
            ],
            'left' => [
                'text' => 'lg:col-start-8 lg:col-end-13',
                'media' => 'lg:col-span-6'
            ],
        ],
    ];

    public ?string $containerClass = null;
    public ?string $mediaClass = null;
    public ?string $contentClass = null;

    public ?array $title = null;
    public ?string $uptitle = null;
    public ?string $content = null;

    public bool $isVideo = false;
    public bool $isImage = false;
    public bool $isYouTube = false;

    public string $mediaPosition = 'left';
    public bool $mediaHasRatio = false;
    public ?string $mediaRatio = null;
    public ?string $ratioClass = null;
    public ?array $image = null;
    public ?array $video = null;
    public ?array $thumbnail = null;
    public ?string $idYouTube = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array  $fields = [],
        public ?string $class = null,
    )
    {
        $this->handleTitles();
        $this->handleContent();
        $this->handleMediaPosition();
        $this->handleMedia();
        $this->handleMediaRatio();

        $this->handleClasses();
    }

    private function handleTitles(): void
    {
        if (isset($this->fields[HeadingField::NAME]) && $this->fields[HeadingField::NAME]) {
            $this->title = $this->fields[HeadingField::NAME];
        }

        if (isset($this->fields[UptitleField::NAME]) && $this->fields[UptitleField::NAME]) {
            $this->uptitle = $this->fields[UptitleField::NAME];
        }
    }

    private function handleContent(): void
    {
        if (isset($this->fields[WysiwygField::WYSIWYG]) && $this->fields[WysiwygField::WYSIWYG]) {
            $this->content = $this->fields[WysiwygField::WYSIWYG];
        }
    }

    private function handleMediaPosition(): void
    {
        if (isset($this->fields[LayoutField::MEDIA_POSITION]) && $this->fields[LayoutField::MEDIA_POSITION]) {
            $tempPosition = $this->fields[LayoutField::MEDIA_POSITION];

            if (in_array($tempPosition, self::MEDIA_POSITIONS)) {
                $this->mediaPosition = $tempPosition;
            }
        }
    }

    private function handleMediaRatio(): void
    {
        if ($this->isImage || $this->isVideo || $this->isYouTube) {
            if (isset($this->fields[LayoutField::MEDIA_RATIO]) && $this->fields[LayoutField::MEDIA_RATIO]) {
                $ratioData = $this->fields[LayoutField::MEDIA_RATIO];

                if (is_array($ratioData)) {
                    if (isset($ratioData[LayoutField::HAS_MEDIA_RATIO]) && $ratioData[LayoutField::HAS_MEDIA_RATIO]) {
                        if (isset($ratioData[LayoutField::MEDIA_RATIO_VALUE]) && $ratioData[LayoutField::MEDIA_RATIO_VALUE]) {
                            if (in_array($ratioData[LayoutField::MEDIA_RATIO_VALUE], self::MEDIA_RATIOS)) {
                                $this->mediaHasRatio = true;
                                $this->mediaRatio = $ratioData[LayoutField::MEDIA_RATIO_VALUE];
                            }
                        }
                    }
                }
            }
        }

        if (!$this->mediaHasRatio || $this->mediaRatio === 'auto') {
            $this->mediaRatio = 'paysage';
            $this->mediaHasRatio = true;

            $baseImage = null;

            if ($this->isImage) {
                $baseImage = $this->image;
            } elseif ($this->isVideo || $this->isYouTube) {
                $baseImage = $this->thumbnail;
            }

            if ($baseImage && isset($baseImage['height'], $baseImage['width'])) {
                if ($baseImage['height'] > $baseImage['width']) {
                    $this->mediaRatio = 'portrait';
                }
            }
        }

        switch ($this->mediaRatio) {
            case 'portrait':
                $this->ratioClass = 'aspect-square';
                break;
            case 'paysage':
                $this->ratioClass = 'aspect-[4/3]';
                break;
            default:
                break;
        }
    }

    private function handleMedia(): void
    {
        if (isset($this->fields[MediaField::MEDIA]) && $this->fields[MediaField::MEDIA]) {
            $mediaData = $this->fields[MediaField::MEDIA];

            if (is_array($mediaData) && isset($mediaData[MediaField::TYPE])) {
                $type = $mediaData[MediaField::TYPE];

                switch ($type) {
                    case 'image':
                        if (isset($mediaData['image'])) {
                            if ($mediaData['image']) {
                                $this->isImage = true;
                                $this->image = $mediaData['image'];
                            }
                        }
                        break;
                    case 'video':
                        if (isset($mediaData['video'])) {
                            if (isset($mediaData['video'][VideoField::IS_YOUTUBE])) {
                                if ($mediaData['video'][VideoField::IS_YOUTUBE]) {
                                    if (isset($mediaData['video'][VideoField::ID_YOUTUBE])) {
                                        $this->isYouTube = true;
                                        $this->idYouTube = $mediaData['video'][VideoField::ID_YOUTUBE];
                                    }
                                } elseif (isset($mediaData['video'][VideoField::VIDEO_FILE]) && $mediaData['video'][VideoField::VIDEO_FILE]) {
                                    $file = $mediaData['video'][VideoField::VIDEO_FILE];
                                    if (is_array($file)) {
                                        $this->isVideo = true;
                                        $this->video = $file;
                                    }
                                }
                            }

                            if ($this->isVideo || $this->isYouTube) {
                                if (isset($mediaData['video'][VideoField::THUMBNAIL])) {
                                    $this->thumbnail = $mediaData['video'][VideoField::THUMBNAIL];
                                }
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    private function handleClasses(): void
    {
        $this->containerClass = 'grid items-center gap-6 lg:grid-cols-12';

        $this->mediaClass = implode(' ', [
            'col-span-full',
            self::POSITIONS[$this->mediaRatio][$this->mediaPosition]['media'],
        ]);

        $this->contentClass = implode(' ', [
            'col-span-full',
            self::POSITIONS[$this->mediaRatio][$this->mediaPosition]['text'],
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.text-media');
    }
}
