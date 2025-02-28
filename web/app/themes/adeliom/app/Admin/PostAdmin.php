<?php

declare(strict_types=1);

namespace App\Admin;

use Adeliom\HorizonTools\Admin\AbstractAdmin;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Text;
use Extended\ACF\Location;

class PostAdmin extends AbstractAdmin
{
    public static ?string $title = 'PostAdmin';
    public static bool $isOptionPage = false;
    public static ?string $optionPageIcon = null;

    public function getFields(): ?iterable
    {
        yield Text::make(__('Test'), 'test');

        yield Group::make(__('Truc'),'truc')->fields([Text::make(__('Stuff'), 'stuff')]);
    }

    public function getLocation(): iterable
    {
        yield Location::where('post_type', 'post');
    }
}
