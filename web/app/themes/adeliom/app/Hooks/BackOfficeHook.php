<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Hooks\AbstractHook;
use Adeliom\HorizonTools\Services\BudService;
use App\Admin\OptionPageAdmin;

class BackOfficeHook extends AbstractHook
{
    public static function enqueueAdminScripts(): void
    {

        if ($adminCss = BudService::getUrl('app.css')) {
            wp_enqueue_style('admin', $adminCss);
        }

        if ($adminJs = BudService::getUrl('app.js')) {
            wp_enqueue_script('admin', $adminJs, ['jquery'], null, true);
        }

        if ($editorCss = BudService::getUrl('editor.css')) {
            wp_enqueue_style('editor', $editorCss);
        }

        if ($editorJs = BudService::getUrl('editor.js')) {
            wp_enqueue_script('editor', $editorJs, ['jquery'], null, true);
        }

        $script = get_field(OptionPageAdmin::FIELD_SCRIPTS, 'option');
        if (!empty($script[OptionPageAdmin::FIELD_ADMIN_SCRIPTS])) {
            echo $script[OptionPageAdmin::FIELD_ADMIN_SCRIPTS];
        }
    }

    public static function allowPrivacyPagetoEditor($caps, $cap, $user_id, $args)
    {
        if ('manage_privacy_options' === $cap) {
            $manage_name = is_multisite() ? 'manage_network' : 'manage_options';
            $caps = array_diff($caps, [$manage_name]);
        }
        return $caps;
    }

    public function init(): void
    {

        add_action('admin_enqueue_scripts', [
            $this,
            'enqueueAdminScripts',
        ]);

        add_action('map_meta_cap', [
            $this,
            'allowPrivacyPagetoEditor',
        ], 1, 4);

    }
}