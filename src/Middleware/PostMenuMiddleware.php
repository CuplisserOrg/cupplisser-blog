<?php namespace Cupplisser\Blog\Middleware;

use Closure;
use Lavary\Menu\Menu;

class PostMenuMiddleware{
    public function handle($request, Closure $next)
    {

        \Menu::make('admin_sidebar', function ($menu) {

            // Articles Dropdown
            $articles_menu = $menu->add('<i class="c-sidebar-nav-icon fas fa-file-alt"></i> Article', [
                'class' => 'c-sidebar-nav-dropdown',
            ])
            ->data([
                'order'         => 81,
                'activematches' => [
                    'admin/posts*',
                    'admin/categories*',
                ],
                // 'permission' => ['view_posts', 'view_categories'],
            ]);
            $articles_menu->link->attr([
                'class' => 'c-sidebar-nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Posts
            $articles_menu->add('<i class="c-sidebar-nav-icon fas fa-file-alt"></i> Posts', [
                'route' => 'cblog::posts.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 82,
                'activematches' => 'admin/posts*',
                'permission'    => ['edit_posts'],
            ])
            ->link->attr([
                'class' => "c-sidebar-nav-link",
            ]);
            // Submenu: Categories
            $articles_menu->add('<i class="c-sidebar-nav-icon fas fa-sitemap"></i> Categories', [
                'route' => 'cblog::categories.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 83,
                'activematches' => 'admin/categories*',
                'permission'    => ['edit_categories'],
            ])
            ->link->attr([
                'class' => "c-sidebar-nav-link",
            ]);
        })->sortBy('order');

        return $next($request);
    }
}
