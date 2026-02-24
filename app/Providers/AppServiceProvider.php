<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Services\MenuService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('layouts.partials.admin.navbar-vertical-admin', function ($view) {
            if (Auth::check()) {
                $menuService = app(MenuService::class);

                $menus = $menuService->getMenuByRole(
                    Auth::user()->role_id,
                    'admin'
                );

                $view->with('dynamicMenus', $menus);
            }
        });

        View::composer('layouts.partials.admin.navbar-vertical-user', function ($view) {
            if (Auth::check()) {
                $menuService = app(MenuService::class);

                $menus = $menuService->getMenuByRole(
                    Auth::user()->role_id,
                    'user'
                );

                $view->with('dynamicMenus', $menus);
            }
        });
    }

    private function getMenusForCurrentUser(string $context)
    {
        $user = auth()->user();
        $roleId = $user?->role_id;

        if (!$roleId) {
            return collect();
        }

        return Menu::query()
            ->where('context', $context)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->whereHas('roles', fn($q) => $q->where('roles.id', $roleId))
            ->with([
                'children' => fn($q) => $q
                    ->where('is_active', true)
                    ->whereHas('roles', fn($q) => $q->where('roles.id', $roleId))
                    ->orderBy('sort_order'),
            ])
            ->orderBy('sort_order')
            ->get();
    }
}