import domReady from '@roots/sage/client/dom-ready';
import '@fortawesome/fontawesome-pro/css/all.css';
import '@scripts/navigations/menu';
import '@scripts/structure/modal';
import '@scripts/layouts/page';

/**
 * Application entrypoint
 */
domReady(async () => {
    // Livewire.start();
});

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
//@ts-expect-error
if (import.meta.webpackHot) import.meta.webpackHot.accept(console.error);
