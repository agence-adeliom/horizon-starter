<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Hooks\AbstractHook;

class Wysiwyg extends AbstractHook
{
    public function init(): void
    {
        add_filter("tiny_mce_before_init", [$this, "addCustomStyle"]);
    }

    public static function addCustomStyle($settings)
    {
        $style_formats = [
            [
                'title' => 'Paragraphes',
                'items' => [
                    [
                        'title' => 'Texte large',
                        'wrapper' => false,
                        'selector' => 'h2, h3, h4, h5, h6, p',
                        'attributes' => [
                            'class' => 'text-xl',
                        ],
                        'remove' => 'none'
                    ],
                ],
            ],
            [
                'title' => 'Listes',
                'items' => [
                    [
                        'title' => 'Couleur auto',
                        'attributes' => [
                            'class' => 'list-check list-check--auto',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Blanc',
                        'attributes' => [
                            'class' => 'list-check list-check--white',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Bleu',
                        'attributes' => [
                            'class' => 'list-check list-check--secondary-02',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Bleu roi',
                        'attributes' => [
                            'class' => 'list-check list-check--secondary-03',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Jaune',
                        'attributes' => [
                            'class' => 'list-check list-check--secondary-06',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Noir',
                        'attributes' => [
                            'class' => 'list-check list-check--brand-02',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Orange',
                        'attributes' => [
                            'class' => 'list-check list-check--brand-01',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Orange ERP',
                        'attributes' => [
                            'class' => 'list-check list-check--secondary-01',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Rose',
                        'attributes' => [
                            'class' => 'list-check list-check--secondary-04',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Vert',
                        'attributes' => [
                            'class' => 'list-check list-check--secondary-05',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ],
                    [
                        'title' => 'Violet',
                        'attributes' => [
                            'class' => 'list-check list-check--secondary-07',
                        ],
                        'selector' => 'ul',
                        'remove' => 'none',
                    ]
                ],
            ],
        ];

        // Insert the array, JSON ENCODED, into 'style_formats'
        $settings['style_formats'] = json_encode($style_formats);

        return $settings;
    }
}