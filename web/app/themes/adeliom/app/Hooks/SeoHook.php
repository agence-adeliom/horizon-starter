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
            'wrap_before' => '<nav aria-label="breadcrumbs" id="breadcrumbs" class="main-breadcrumbs">',
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

    public static function rmBreadcrumbHtml($html, $crumbs, $class): string
    {
        $iconFactory = app(Factory::class);

        return preg_replace(
            '/<span class="separator">.*?<\/span>/',
            $iconFactory->svg('fas:sharp-angle-right', 'separator w-[16px] h-[16px] text-secondary')->toHtml(),
            $html,
        );
    }

    public function init(): void
    {
        add_filter('rank_math/frontend/breadcrumb/args', [$this, 'rmBreadcrumbArgs'], 10, 1);

        add_filter('rank_math/frontend/breadcrumb/settings', [$this, 'rmBreadcrumbSettings'], 10, 1);
        add_filter('rank_math/frontend/breadcrumb/html', [$this, 'rmBreadcrumbHtml'], 10, 3);
    }
}
