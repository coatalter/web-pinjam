@forelse ($menus as $menu)
    <li class="px-4 py-2 hover:bg-gray-100">
        <a href="{{ route($menu->route_name) }}">
            {{ $menu->name }}
        </a>
    </li>
@empty
    <li class="px-4 py-2 text-gray-400">
        Menu tidak ditemukan
    </li>
@endforelse
