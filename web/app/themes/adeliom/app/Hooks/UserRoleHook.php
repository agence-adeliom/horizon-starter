<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Hooks\AbstractHook;

class UserRoleHook extends AbstractHook
{
    public static function addEditorRoles(): void
    {
        $role = get_role('editor');
        $caps = [
            // gravity forms
            'gravityforms_view_entries',
            'gravityforms_edit_entries',
            'gravityforms_delete_entries',
            'gravityforms_export_entries',
            'gravityforms_view_entry_notes',
            'gravityforms_edit_forms',
            'gravityforms_create_form',
            'gravityforms_delete_forms',
            'gravityforms_preview_forms',
            'gravityforms_edit_settings',
            'gravityforms_edit_other_forms',
            'gravityforms_delete_other_forms',
            'gravityforms_view_forms',
        ];

        foreach ($caps as $cap) {
            if (!$role->has_cap($cap)) {
                $role->add_cap($cap);
            }
        }
    }

    public function init(): void
    {
        add_action('admin_init', [$this, 'addEditorRoles'], 10);
    }
}
