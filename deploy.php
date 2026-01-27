<?php

namespace Deployer;

require 'recipe/wordpress.php';

// Set WP-CLI path and install if not found
set('bin/wp', function () {
    if (test('[ -f {{deploy_path}}/.dep/wp-cli.phar ]')) {
        return '{{bin/php}} {{deploy_path}}/.dep/wp-cli.phar';
    }

    if (commandExist('wp')) {
        return 'wp'; // Assumes WP-CLI is globally accessible in PATH
    }

    warning("WP-CLI binary wasn't found. Installing latest WP-CLI to \"{{deploy_path}}/.dep/wp-cli.phar\".");
    run('curl -o {{deploy_path}}/.dep/wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar');
    return '{{bin/php}} {{deploy_path}}/.dep/wp-cli.phar';
});

set('repository', 'git@github.com:agence-adeliom/si-2024.git');

set('theme', 'adeliom');

set('shared_dirs', ['web/app/uploads', 'web/app/languages', 'web/app/sessions']);

set('shared_files', ['web/.htaccess', 'auth.json', '.env']);

set('writable_dirs', []);

set('writable_mode', 'chmod');
set('writable_recursive', true);

set('bin/composer', function () {
    run('cd {{release_path}} && curl -sS https://getcomposer.org/installer | {{bin/php}}');
    $composer = '{{bin/php}} {{release_path}}/composer.phar';
    return $composer;
});

// Hosts
import('.inventory.yml');

task('npm:install-and-build', function () {
    $debug = false;

    // Install, build assets and make a tar.gz to upload to server
    info('Building theme assets locally and building a .tar.gz file...');
    $buildFileName = sprintf('build_%s.tar.gz', date('Ymd_His'));

    runLocally(
        sprintf(
            'cd web/app/themes/{{theme}} && npm install %s && npm run build %s && cd public/build && rm -rf %s %s && tar --exclude="%s" -czf ../%s . %s && mv ../%s .',
            !$debug ? '> /dev/null 2>&1' : null,
            !$debug ? '> /dev/null 2>&1' : null,
            $buildFileName,
            !$debug ? '> /dev/null 2>&1' : null,
            $buildFileName,
            $buildFileName,
            !$debug ? '> /dev/null 2>&1' : null,
            $buildFileName,
        ),
    );

    // Create the build directory on the server
    info('Creating build directory on server...');
    run('cd {{release_path}}/web/app/themes/{{theme}}/public && mkdir build');

    // Upload the tar.gz on the server
    info('Uploading build .tar.gz to server...');
    upload(sprintf('web/app/themes/{{theme}}/public/build/%s', $buildFileName), '{{release_path}}/web/app/themes/{{theme}}/public/build/');

    // Extract the build on the server and remove the local tar.gz
    info('Extracting build on server and cleaning up...');
    run(sprintf('cd {{release_path}}/web/app/themes/{{theme}}/public/build && tar -xzvf %s && rm %s', $buildFileName, $buildFileName));
    runLocally(sprintf('cd web/app/themes/{{theme}}/public/build && rm -rf %s', $buildFileName));
});

task('deploy:language', static function (): void {
    info('Vérification de l’installation de WordPress en cours...');

    within('{{release_or_current_path}}', function () {
        if (!test('{{bin/wp}} core is-installed 2>/dev/null')) {
            warning('WordPress n’est pas installé dans le répertoire actuel.');
        } else {
            $pluginTranslationsOutput = run('{{bin/wp}} plugin list --field=name --format=json');
            info('Récupération des traductions des plugins...');

            $pluginTranslations = json_decode($pluginTranslationsOutput, true);

            foreach ($pluginTranslations as $plugin) {
                if (!test("{{bin/wp}} language plugin is-installed $plugin fr_FR")) {
                    run("{{bin/wp}} language plugin install $plugin fr_FR");
                    info("Installation de la traduction pour le plugin $plugin");
                } else {
                    run("{{bin/wp}} language plugin update $plugin fr_FR");
                    info("Mise à jour de la traduction pour le plugin $plugin");
                }
            }

            if (!test("{{bin/wp}} language core is-installed $plugin fr_FR")) {
                run('{{bin/wp}} language core install fr_FR');
                info('Installation de la langue principale pour le core de WordPress');
            } else {
                run('{{bin/wp}} language core update fr_FR');
                info('Mise à jour de la langue principale pour le core de WordPress');
            }
        }
    });
});

// Task to reset the W3 Total Cache plugin
task('reset:cache', static function (): void {
    within('{{release_or_current_path}}', function () {
        if (!test('{{bin/wp}} core is-installed 2>/dev/null')) {
            warning('WordPress n\'est pas installé dans le répertoire actuel.');
        } else {
            if (!test('{{bin/wp}} plugin is-installed w3-total-cache && {{bin/wp}} plugin is-active w3-total-cache')) {
                warning('W3 Total Cache is not installed or active.');
            } else {
                // If installed and active, trigger the cache flush_all command
                run('{{bin/wp}} w3-total-cache flush all');
                info('W3 Total Cache cleared successfully!');
            }
        }
    });
});

task('install:theme', function () {
    run('cd {{release_or_current_path}}/web/app/themes/adeliom && {{bin/composer}} install');
});

task('cache:icons', static function (): void {
    within('{{release_or_current_path}}', function () {
        run('{{bin/wp}} acorn icons:cache');
        info('✅ Les icones Blade ont été mis en cache avec succès!');
    });
});

option('command', null, InputOption::VALUE_OPTIONAL, 'Command arguments if required');

task('wp-cli', function () {
    $wpCliCommand = input()->getOption('command');

    while (empty($wpCliCommand)) {
        $wpCliCommand = ask('Quelle commande lancer sur l’environnement {{stage}} ?');
    }

    info('Téléchargement de WP-CLI');
    run('cd {{release_or_current_path}}/web && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar');

    info('Lancement de la commande WP-CLI : ' . $wpCliCommand);
    $commandResult = run('cd {{release_or_current_path}}/web && {{bin/php}} wp-cli.phar ' . $wpCliCommand);
    writeln(PHP_EOL . print_r($commandResult, true));

    info('Suppression de WP-CLI');
    run('cd {{release_or_current_path}}/web && rm wp-cli.phar');
});

task('acorn', function () {
    $acornCommand = input()->getOption('command');

    while (empty($acornCommand)) {
        $acornCommand = ask('Quelle commande lancer sur l’environnement {{stage}} ?');
    }

    info('Téléchargement de WP-CLI');
    run('cd {{release_or_current_path}}/web && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar');

    info('Lancement de la commande Acorn : ' . $acornCommand);
    $commandResult = run('cd {{release_or_current_path}}/web && {{bin/php}} wp-cli.phar acorn ' . $acornCommand);
    writeln(PHP_EOL . print_r($commandResult, true));

    info('Suppression de WP-CLI');
    run('cd {{release_or_current_path}}/web && rm wp-cli.phar');
});

fail('wp-cli', function () {
    info('Suppression de WP-CLI');
    run('cd {{release_or_current_path}}/web && rm wp-cli.phar');
});

fail('acorn', function () {
    info('Suppression de WP-CLI');
    run('cd {{release_or_current_path}}/web && rm wp-cli.phar');
});

// Define deployment flow
before('deploy:vendors', 'deploy:shared');
after('deploy:update_code', 'deploy:vendors');
after('deploy:vendors', 'install:theme');
before('deploy:symlink', 'npm:install-and-build');
after('npm:install-and-build', 'deploy:language');
after('deploy:symlink', 'reset:cache');
after('reset:cache', 'cache:icons');
after('deploy:failed', 'deploy:unlock');
