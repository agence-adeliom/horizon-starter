<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Hooks\AbstractHook;

/**
 * Traitements des contenus éditoriaux (WYSIWYG ACF et contenu des articles et pages)
 */
class ContentHook extends AbstractHook
{
    private const string NEW_TAB_MENTION_PATTERN = '/nouvel onglet|nouvelle fenêtre/i';

    public function init(): void
    {
        add_filter('acf/format_value/type=wysiwyg', [$this, 'addNewTabMention'], 20);
        add_filter('the_content', [$this, 'addNewTabMention'], 20);

        // pas de fetchpriority automatique sur les images de contenu
        add_filter('wp_omit_loading_attr_threshold', fn(): int => 0);
    }

    /**
     * Signale aux lecteurs d'écran les liens qui s'ouvrent dans un nouvel onglet 
     */
    public function addNewTabMention(mixed $content): mixed
    {
        if (!is_string($content) || !str_contains($content, '_blank')) {
            return $content;
        }

        return preg_replace_callback(
            '/(<a\b[^>]*\btarget=(["\'])_blank\2[^>]*>)(.*?)(<\/a>)/is',
            function (array $matches): string {
                [, $openingTag,, $innerHtml, $closingTag] = $matches;

                $ariaLabel = preg_match('/\baria-label=(["\'])(.*?)\1/is', $openingTag, $label) ? $label[2] : null;

                if (preg_match(self::NEW_TAB_MENTION_PATTERN, $ariaLabel ?? wp_strip_all_tags($innerHtml))) {
                    return $matches[0];
                }

                $mention = __('Ouvrir dans un nouvel onglet', 'sage');

                if (null !== $ariaLabel) {
                    $openingTag = str_replace($label[0], sprintf('aria-label="%s - %s"', $ariaLabel, esc_attr($mention)), $openingTag);

                    return $openingTag . $innerHtml . $closingTag;
                }

                return sprintf('%s%s<span class="sr-only"> - %s</span>%s', $openingTag, $innerHtml, esc_html($mention), $closingTag);
            },
            $content,
        ) ?? $content;
    }
}
