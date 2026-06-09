<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Hooks\AbstractHook;

/**
 * Aligne le support « visibility » de WordPress 7.0 sur nos breakpoints Tailwind.
 *
 * Le core (wp-includes/block-supports/block-visibility.php) ajoute les classes
 * wp-block-hidden-{mobile,tablet,desktop} ET génère lui-même le CSS associé avec des
 * breakpoints codés en dur (480 / 782px), sans exposer le moindre filtre dessus.
 *
 * On retire donc son rendu et on le remplace par une version qui se limite à ajouter
 * les classes : les media queries proviennent de notre CSS Tailwind
 * (resources/styles/utilities/block-visibility.css), seule source de vérité des breakpoints.
 *
 * @see wp-includes/block-supports/block-visibility.php
 */
class BlockVisibilityHook extends AbstractHook
{
    /** Slugs de viewport gérés par le support « visibility » de WordPress. */
    private const VIEWPORTS = ['mobile', 'tablet', 'desktop'];

    public function init(): void
    {
        remove_filter('render_block', 'wp_render_block_visibility_support', 10);
        add_filter('render_block', [$this, 'renderBlockVisibility'], 10, 2);
    }

    /**
     * Calque allégé de wp_render_block_visibility_support() : ajout des classes
     * uniquement, sans génération de CSS (déléguée à Tailwind).
     */
    public function renderBlockVisibility(string $block_content, array $block): string
    {
        $block_type = \WP_Block_Type_Registry::get_instance()->get_registered($block['blockName'] ?? '');

        if (!$block_type || !block_has_support($block_type, 'visibility', true)) {
            return $block_content;
        }

        $block_visibility = $block['attrs']['metadata']['blockVisibility'] ?? null;

        // Bloc entièrement masqué (visibilité globale à false).
        if (false === $block_visibility) {
            return '';
        }

        if (!is_array($block_visibility) || empty($block_visibility)) {
            return $block_content;
        }

        $viewport_config = $block_visibility['viewport'] ?? null;

        if (!is_array($viewport_config) || empty($viewport_config)) {
            return $block_content;
        }

        // Viewports sur lesquels le bloc est explicitement masqué.
        $class_names = [];
        foreach ($viewport_config as $viewport => $is_visible) {
            if (false === $is_visible && in_array($viewport, self::VIEWPORTS, true)) {
                $class_names[] = 'wp-block-hidden-' . $viewport;
            }
        }

        if (empty($class_names) || empty($block_content)) {
            return $block_content;
        }

        // Ordre constant pour la génération des classes.
        sort($class_names);

        $processor = new \WP_HTML_Tag_Processor($block_content);
        if ($processor->next_tag()) {
            $processor->add_class(implode(' ', $class_names));

            /*
             * Comme le core : force fetchpriority=auto sur les IMG d'un bloc masquable
             * pour ne pas fausser wp_get_loading_optimization_attributes() (LCP / lazy).
             */
            do {
                if ('IMG' === $processor->get_tag()) {
                    $processor->set_attribute('fetchpriority', 'auto');
                }
            } while ($processor->next_tag());

            $block_content = $processor->get_updated_html();
        }

        return $block_content;
    }
}