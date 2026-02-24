<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // Ambil menu berdasarkan role user login
    public function index()
    {
        $user = Auth::user();

        $menus = Menu::with('childrenRecursive')
            ->whereNull('parent_id')
            ->whereHas('roles', function ($query) use ($user) {
                $query->where('roles.id', $user->role_id);
            })
            ->orderBy('sort_order')
            ->get();

        return response()->json($menus);
    }

    // Tambah menu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'nullable|integer',
            'roles' => 'required|array'
        ]);

        $menu = Menu::create([
            'name' => $request->name,
            'route' => $request->route,
            'parent_id' => $request->parent_id,
            'sort_order' => $request->sort_order ?? 0
        ]);

        $menu->roles()->sync($request->roles);

        return response()->json($menu->load('roles'), 201);
    }

    // Update menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $menu->update($request->only([
            'name',
            'route',
            'parent_id',
            'sort_order'
        ]));

        if ($request->has('roles')) {
            $menu->roles()->sync($request->roles);
        }

        return response()->json($menu->load('roles'));
    }

    // Delete menu
    public function destroy($id)
    {
        $menu = Menu::with('children')->findOrFail($id);

        if ($menu->children()->exists()) {
            return response()->json([
                'message' => 'Cannot delete parent menu with submenus'
            ], 400);
        }

        $menu->roles()->detach();
        $menu->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}