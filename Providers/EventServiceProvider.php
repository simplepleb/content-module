<?php

/**
 * Putting this here to help remind you where this came from.
 *
 * I'll get back to improving this and adding more as time permits
 * if you need some help feel free to drop me a line.
 *
 * * Twenty-Years Experience
 * * PHP, JavaScript, Laravel, MySQL, Java, Python and so many more!
 *
 *
 * @author  Simple-Pleb <plebeian.tribune@protonmail.com>
 * @website https://www.simple-pleb.com
 * @source https://github.com/simplepleb/content-module
 *
 * @license MIT For Premium Clients
 *
 * @since 1.0
 *
 */

namespace Modules\Content\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\Content\Events\ContentCreated' => [
            'Modules\Content\Listeners\ContentCreated\CreateContentData',
        ],
        'Modules\Content\Events\ContentUpdated' => [
            'Modules\Content\Listeners\ContentUpdated\UpdateContentData',
        ],
        'Modules\Content\Events\ContentViewed' => [
            'Modules\Content\Listeners\ContentViewed\IncrementHitCount',
        ],
    ];
}
