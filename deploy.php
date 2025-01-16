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
	run("curl -o {{deploy_path}}/.dep/wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar");
	return '{{bin/php}} {{deploy_path}}/.dep/wp-cli.phar';
});

set('repository', 'git@github.com:agence-adeliom/si-2024.git');

set('theme', 'adeliom');

set('shared_dirs', [
	'web/app/uploads',
	'web/app/languages',
	'web/app/sessions'
]);

set('shared_files', [
	'web/.htaccess',
	'auth.json',
	'.env',
	'web/app/themes/adeliom/.npmrc'
]);

set('writable_dirs', []);

set('writable_mode', "chmod");
set('writable_recursive', true);

set('bin/composer', function () {
	run("cd {{release_path}} && curl -sS https://getcomposer.org/installer | {{bin/php}}");
	$composer = '{{bin/php}} {{release_path}}/composer.phar';
	return $composer;
});

// Hosts
import('.inventory.yml');

// Task to build assets with npm
task('npm:build', static function (): void {
	run('cd {{release_or_current_path}}/web/app/themes/adeliom && {{bin/npm}} install && {{bin/npm}} run build');
});

task('deploy:language', static function (): void {
	info('Vérification de l\'installation de WordPress en cours...');

	within('{{release_or_current_path}}', function () {
		if (!test('{{bin/wp}} core is-installed 2>/dev/null')) {
			warning('WordPress n\'est pas installé dans le répertoire actuel.');
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
				run("{{bin/wp}} language core install fr_FR");
				info('Installation de la langue principale pour le core de WordPress');
			} else {
				run("{{bin/wp}} language core update fr_FR");
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
				run("{{bin/wp}} w3-total-cache flush all");
				info("W3 Total Cache cleared successfully!");
			}
		}
	});
});

task('install:theme', function () {
	run('cd {{release_or_current_path}}/web/app/themes/adeliom && {{bin/composer}} install');
});

// Define deployment flow
before('deploy:vendors', 'deploy:shared');
after('deploy:update_code', 'deploy:vendors');
after('deploy:vendors', 'install:theme');
before('deploy:symlink', 'npm:build');
after('npm:build', 'deploy:language');
after('deploy:symlink', 'reset:cache');
after('deploy:failed', 'deploy:unlock');
