<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;

/**
 * Service provider du thème.
 *
 * Point d'entrée pour étendre le container Acorn côté thème :
 *  - register() : bindings (`$this->app->bind(...)`, `singleton(...)`), merges de config.
 *  - boot()     : view composers, directives Blade, helpers globaux, événements.
 *
 * Pour les hooks WordPress (actions/filters), passer plutôt par une classe
 * dans `app/Hooks/` — voir `app/Hooks/README.md`.
 */
class ThemeServiceProvider extends SageServiceProvider
{
    public function register(): void
    {
        parent::register();

        // Exemple : $this->app->singleton(MyService::class);
    }

    public function boot(): void
    {
        parent::boot();

        // Exemple : View::composer('partials.header', HeaderComposer::class);
    }
}
