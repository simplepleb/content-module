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

namespace Modules\Content\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('admin_sidebar', function ($menu) {

            // Contents Dropdown
            $articles_menu = $menu->add('<i class="c-sidebar-nav-icon fas fa-envelope-open-text"></i> Content', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 87,
                'activematches' => [
                    'admin/contents*',
                    'admin/categories*',
                ],
                'permission' => ['view_posts', 'view_categories'],
            ]);
            $articles_menu->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Posts
            $articles_menu->add('Pages', [
                'route' => 'backend.contents.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 88,
                'activematches' => 'admin/contents*',
                'permission'    => ['edit_posts'],
            ])
            ->link->attr([
                'class' => "c-sidebar-nav-link",
            ]);

        })->sortBy('order');

        return $next($request);
    }
}
