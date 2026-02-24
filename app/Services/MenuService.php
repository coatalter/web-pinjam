<?php

namespace App\Services;

use App\Models\Menu;

class MenuService
{
    public function getMenuByRole($roleId, $context)
    {
        return Menu::with(['children' => function ($query) use ($roleId, $context) {
                $query->where('is_active', true)
                      ->where('context', $context)
                      ->whereHas('roles', function ($q) use ($roleId) {
                          $q->where('roles.id', $roleId);
                      });
            }])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->where('context', $context)
            ->whereHas('roles', function ($query) use ($roleId) {
                $query->where('roles.id', $roleId);
            })
            ->orderBy('sort_order')
            ->get();
    }
}