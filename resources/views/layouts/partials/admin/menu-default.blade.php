@foreach(($dynamicMenus ?? collect()) as $menu)
    @include('layouts.partials.admin.menu-item', ['menu' => $menu])
@endforeach