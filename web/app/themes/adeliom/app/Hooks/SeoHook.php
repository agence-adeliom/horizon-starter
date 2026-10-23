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
     * Breadcrumb as an ordered list: nav > ol > li 
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

    /**
     * The Livewire listings paginate with ?pagination=N, which Rank Math and WordPress ignore: without
     * this filter, every page of a listing declares page 1 as canonical. From page 2, the canonical keeps
     * the pagination parameter (and only it: the filters stay out).
     */
    public static function paginatedCanonical($canonical)
    {
        $page = filter_input(INPUT_GET, 'pagination', FILTER_VALIDATE_INT);

        if (!$canonical || !$page || $page < 2) {
            return $canonical;
        }

        return add_query_arg('pagination', $page, $canonical);
    }

    public function init(): void
    {
        add_filter('get_canonical_url', [$this, 'paginatedCanonical'], 10, 1);

        if (!defined('RANK_MATH_VERSION')) {
            return;
        }

        add_filter('rank_math/frontend/canonical', [$this, 'paginatedCanonical'], 10, 1);

        add_filter('rank_math/frontend/breadcrumb/args', [$this, 'rmBreadcrumbArgs'], 10, 1);

        add_filter('rank_math/frontend/breadcrumb/settings', [$this, 'rmBreadcrumbSettings'], 10, 1);
        add_filter('rank_math/frontend/breadcrumb/html', [$this, 'rmBreadcrumbHtml'], 10, 3);
    }
}
