<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Hooks\AbstractHook;
use Adeliom\HorizonTools\Services\Compilation\CompilationService;
use App\Admin\OptionPageAdmin;

class BackOfficeHook extends AbstractHook
{
    public static function enqueueAdminScripts(): void
    {
        if (get_current_screen()?->is_block_editor()) {
            CompilationService::getAsset('resources/styles/app.css')?->enqueue();
            CompilationService::getAsset('resources/scripts/app.ts')?->enqueueAll(dependencies: ['jquery']);

            CompilationService::getAsset('resources/styles/editor.css')?->enqueue();
            CompilationService::getAsset('resources/scripts/editor.ts')?->enqueueAll(dependencies: ['jquery']);
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
