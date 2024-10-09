<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Hooks\AbstractHook;

class Wysiwyg extends AbstractHook
{
    public static function customStyleFormats($settings): array
    {
        $style_formats = [
           /* [
                'title' => 'Titres',
                'items' => [
                    [
                        'title'      => 'Titre 3xl',
                        'selector'   => 'h2, h3, h4, h5, h6, p',
                        'wrapper'    => false,
                        'remove'     => 'none',
                        'attributes' => [
                            'class' => 'text-3xl',
                        ],
                    ],
                    [
                        'title'      => 'Titre 2xl',
                        'selector'   => 'h2, h3, h4, h5, h6, p',
                        'wrapper'    => false,
                        'remove'     => 'none',
                        'attributes' => [
                            'class' => 'text-2xl',
                        ],
                    ],
                ],
            ],*/
            [
                'title' => 'Paragraphes',
                'items' => [
                    [
                        'title'      => 'Texte large',
                        'wrapper'    => false,
                        'selector'   => 'h2, h3, h4, h5, h6, p',
                        'remove'     => 'none',
                        'attributes' => [
                            'class' => 'text-large',
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Listes',
                'items' => [
                    [
                        'title'      => 'Liste à check',
                        'attributes' => [
                            'class' => 'list list-check',
                        ],
                        'selector'   => 'ul',
                        'remove'     => 'none',
                    ],
                ],
            ],
        ];

        $settings['style_formats'] = json_encode($style_formats);

        return $settings;
    }

    public function init(): void
    {
        add_filter("tiny_mce_before_init", [
            $this,
            "customStyleFormats",
        ]);
    }
}