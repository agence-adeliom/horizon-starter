<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Hooks\AbstractHook;
use BladeUI\Icons\Factory;

class SeoHook extends AbstractHook
{
    public static function rmBreadcrumbArgs($args): array
    {
        return array_merge($args, [
            'wrap_before' => '<nav aria-label="' . esc_attr__('Fil d’Ariane', 'sage') . '" id="breadcrumbs" class="main-breadcrumbs">',
            'wrap_after' => '</nav>',
        ]);
    }

    public static function rmBreadcrumbSettings($args): array
    {
        return array_merge($args, [
            'separator' => static::breadcrumbSeparator(),
        ]);
    }

    public static function breadcrumbSeparator(): string
    {
        return '';
    }

    /**
     * Breadcrumb as an ordered list: nav > ol > li (APG « Breadcrumb » pattern, RGAA 9.3)
     */
    public static function rmBreadcrumbHtml($html, $crumbs, $class): string
    {
        if (empty($crumbs)) {
            return $html;
        }

        $separator = app(Factory::class)->svg('fas:sharp-angle-right', 'separator text-secondary')->toHtml();
        $lastIndex = array_key_last($crumbs);
        $items = '';

        foreach ($crumbs as $index => $crumb) {
            $title = esc_html(wp_strip_all_tags((string) ($crumb[0] ?? '')));

            $items .= $index === $lastIndex
                ? sprintf('<li><span class="last" aria-current="page">%s</span></li>', $title)
                : sprintf('<li><a href="%s">%s</a>%s</li>', esc_url((string) ($crumb[1] ?? '')), $title, $separator);
        }

        return sprintf(
            '<nav aria-label="%s" id="breadcrumbs" class="main-breadcrumbs"><ol role="list">%s</ol></nav>',
            esc_attr__('Fil d’Ariane', 'sage'),
            $items,
        );
    }

    public function init(): void
    {
        if (!defined('RANK_MATH_VERSION')) {
            return;
        }

        add_filter('rank_math/frontend/breadcrumb/args', [$this, 'rmBreadcrumbArgs'], 10, 1);

        add_filter('rank_math/frontend/breadcrumb/settings', [$this, 'rmBreadcrumbSettings'], 10, 1);
        add_filter('rank_math/frontend/breadcrumb/html', [$this, 'rmBreadcrumbHtml'], 10, 3);
    }
}
