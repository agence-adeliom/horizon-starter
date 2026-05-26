<?php

/**
 * Filtres WordPress génériques du thème (excerpt, output buffers, etc.).
 *
 * Pour des features plus structurées, préférer une classe dans `app/Hooks/`.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});
