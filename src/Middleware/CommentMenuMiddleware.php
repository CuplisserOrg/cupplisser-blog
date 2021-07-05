<?php namespace Cupplisser\Blog\Middleware;

use Closure;
use Lavary\Menu\Menu;

class CommentMenuMiddleware{
    public function handle($request, Closure $next)
    {

        \Menu::make('admin_sidebar', function ($menu) {

            // comments
            $menu->add('<i class="fas fa-comments c-sidebar-nav-icon"></i> Comments', [
                'route' => 'cblog::comments.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 85,
                'activematches' => ['admin/comments*'],
                'permission' => ['view_comments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}
