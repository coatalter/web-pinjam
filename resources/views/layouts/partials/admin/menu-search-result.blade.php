@forelse($menus as $menu)
    @include('layouts.partials.admin.menu-item', ['menu' => $menu])
@empty
    <div class="px-3 py-2 text-sm text-navy-200">
        Menu tidak ditemukan
    </div>
@endforelse