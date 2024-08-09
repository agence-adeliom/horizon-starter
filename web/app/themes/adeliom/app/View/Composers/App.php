<?php

namespace App\View\Composers;

use App\PostTypes\LandingPage;
use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'siteName' => $this->siteName(),
            'postType' => get_post_type(),
            'isLp'     => self::isLandingPage(),
        ];
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }

    public static function isLandingPage(): string
    {
        return get_post_type() === LandingPage::$slug;
    }
}