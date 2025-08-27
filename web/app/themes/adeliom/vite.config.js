import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';

const isProduction = process.env.NODE_ENV === 'production';
const primaryUrl = process.env.DDEV_PRIMARY_URL || 'http://localhost';
const url = new URL(primaryUrl);

export default defineConfig({
    base: isProduction ? '/app/themes/adeliom/public/build/' : '',

    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/styles/app.css', 'resources/scripts/app.ts', 'resources/styles/editor.css', 'resources/scripts/editor.ts'],
            refresh: true, // automatique en dev
        }),
        wordpressPlugin(),
        wordpressThemeJson({
            disableTailwindColors: false,
            disableTailwindFonts: false,
            disableTailwindFontSizes: false,
        }),
    ],

    resolve: {
        alias: {
            '@scripts': '/resources/scripts',
            '@styles': '/resources/styles',
            '@fonts': '/resources/fonts',
            '@images': '/resources/images',
        },
    },

    build: {
        rollupOptions: {
            output: {
                manualChunks: () => null,
            },
        },
    },

    server: {
        host: '0.0.0.0', // écoute toutes les interfaces dans le conteneur
        port: 5174, // port interne
        strictPort: true,
        cors: true,
        hmr: {
            host: url.hostname, // hostname public DDEV
            protocol: url.protocol === 'https:' ? 'wss' : 'ws',
        },
    },
});
