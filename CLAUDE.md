# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

WordPress project using **Roots Bedrock** + **Sage 11** theme (named `adeliom`) with **Acorn 5** (Laravel-in-WordPress). The project is built by Agence Adeliom and uses their internal Horizon packages. Primary language is French (comments, README, deployment messages).

## Architecture

```
/                                    # Bedrock root
├── config/                          # Bedrock WP config (application.php, environments/)
├── web/                             # Document root
│   ├── wp/                          # WordPress core (Composer-managed, don't edit)
│   └── app/
│       └── themes/adeliom/          # ← Main theme (all development happens here)
│           ├── app/                  # PHP classes (PSR-4: App\)
│           │   ├── Admin/           # WP admin customizations
│           │   ├── Blocks/          # ACF Gutenberg blocks
│           │   ├── Fields/          # ACF field definitions
│           │   ├── Hooks/           # WP action/filter hooks
│           │   ├── Livewire/        # Livewire interactive components
│           │   ├── PostTypes/       # Custom post types
│           │   ├── Providers/       # Service providers (ThemeServiceProvider)
│           │   ├── Repositories/    # Data access layer
│           │   ├── Services/        # Business logic
│           │   ├── Taxonomies/      # Custom taxonomies
│           │   └── View/
│           │       ├── Composers/   # View composers (bind data to templates)
│           │       └── Components/  # Blade components (Ui, Form, Cards, etc.)
│           ├── resources/
│           │   ├── scripts/         # TypeScript (app.ts, editor.ts)
│           │   ├── styles/          # Tailwind CSS (app.css, editor.css)
│           │   ├── views/           # Blade templates
│           │   └── icons/           # SVG icons (Blade)
│           ├── config/              # Theme-level configs (gutenberg, seo, medias, etc.)
│           ├── public/build/        # Vite build output
│           ├── vite.config.js
│           └── tailwind.config.js
├── deploy.php                       # Deployer v7.4 config
└── composer.json                    # Root dependencies (WP, plugins, Horizon packages)
```

Two levels of Composer: root (Bedrock + plugins) and theme-level (`web/app/themes/adeliom/composer.json`).

## Development Commands

**Toujours utiliser DDEV pour exécuter les commandes.** Ne jamais lancer `composer`, `npm`, `wp`, `php` ou `acorn` directement depuis le host. Toutes les commandes passent par `ddev` (ex: `ddev composer`, `ddev npm`, `ddev wp`).

```bash
# Environment
ddev start                          # Start local environment
ddev acorn key:generate             # Generate APP_KEY (required for Livewire)

# Theme assets (dev server with HMR on port 3001)
ddev theme:install                  # npm install in theme
ddev theme:dev                      # Vite dev server (access site on :3001 for live reload)
ddev theme:build                    # Production build

# Scaffolding (generates classes in theme app/ directory)
ddev acorn make:block Path/BlockName
ddev acorn make:posttype Path/PostTypeName
ddev acorn make:taxonomy Path/TaxonomyName
ddev acorn make:hook Path/HookName
ddev acorn make:admin Path/AdminName
ddev acorn make:template Path/TemplateName

# Listing content
ddev acorn list:blocks
ddev acorn list:posttypes
ddev acorn list:taxonomies

# Dependencies
ddev composer install               # Install root PHP dependencies
ddev composer test                  # PHP_CodeSniffer (PSR-2)

# Deployment (Deployer)
ddev deployer deploy <stage>
ddev deployer wp-cli <stage> --command="cache flush"      # WP-CLI sur un environnement distant
ddev deployer acorn <stage> --command="icons:cache"       # Acorn sur un environnement distant

# Transferts DB / uploads (recipe horizon-transfer, cf. README)
ddev deployer db:pull <stage>                             # distant → local : dump, import, search-replace
ddev deployer uploads:pull <stage> [--favicon-only]       # distant → local
ddev deployer db:push --from=<env> --to=<stage>           # backup de la destination, puis import
ddev deployer uploads:push --from=<env> --to=<stage>      # --strategy=merge|mirror, --checksum
```

Un « environnement » est `local` ou l'alias d'un hôte Deployer. Un `push` vise toujours un hôte distant et demande
confirmation ; les hôtes dont l'alias ou le stage contient `prod` exigent la saisie de l'alias en clair.

## Code Style

- **PHP:** PSR-2 via PHP_CodeSniffer; 4-space indent. Laravel Pint available in theme for formatting.
- **Blade templates:** 2-space indent.
- **JS/TS/CSS:** Prettier with single quotes, trailing commas, 140 char print width, 4-space indent.
- **Blade files:** Parsed with `prettier-plugin-blade`.

## Key Technical Details

- **PHP >=8.4**, **Node >=20**, Vite 6, Tailwind CSS v4.1
- Vite entry points: `resources/styles/app.css`, `resources/scripts/app.ts`, `resources/styles/editor.css`, `resources/scripts/editor.ts`
- Vite aliases: `@scripts`, `@styles`, `@fonts`, `@images` (resolve to `resources/` subdirs)
- Tailwind uses CSS custom properties (`--awc-*`) for design tokens (colors, spacing, typography)
- Theme service providers registered in theme `composer.json` under `extra.acorn.providers`
- Internal packages: `horizon-tools`, `horizon-blocks`, `horizon-querybuilder` (git VCS repos, `dev-sage/11` branch), `horizon-deployer-recipe` (dev only)
- These repos are private: `auth.json` must carry a `github-oauth` token in addition to the ACF Pro key
- `deploy.php` loads the transfer recipe with `require_once` (a second `require` is a fatal redeclaration). Any override of its settings — `uploads_path`, `transfer_protected`, `transfer_search_replace_skip_tables`, `bin/wp`, `bin/wp_local` — must come **after** that `require_once`
- ACF Pro is installed as a must-use plugin via Composer
- Frontend libs: Alpine.js, Swiper, GLightbox, Choices.js

## Commit Convention

```
feat(scope): description     # New feature
fix(scope): description      # Bug fix
chore(scope): description    # Maintenance
refactor(scope): description # Code reorganization
```
