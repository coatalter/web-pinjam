<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.partials.admin.navbar-vertical-admin', function ($view) {
            $view->with('dynamicMenus', $this->getMenusForCurrentUser('admin'));
        });

        View::composer('layouts.partials.admin.navbar-vertical-user', function ($view) {
            $view->with('dynamicMenus', $this->getMenusForCurrentUser('user'));
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
            ->whereHas('roles', fn ($q) => $q->where('roles.id', $roleId))
            ->with([
                'children' => fn ($q) => $q
                    ->where('is_active', true)
                    ->whereHas('roles', fn ($q) => $q->where('roles.id', $roleId))
                    ->orderBy('sort_order'),
            ])
            ->orderBy('sort_order')
            ->get();
    }
}
