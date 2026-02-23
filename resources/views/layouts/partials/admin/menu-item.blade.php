@php
    /** @var \App\Models\Menu $menu */
    $hasChildren = $menu->children?->isNotEmpty();
    $collapseId = 'menuCollapse' . $menu->id;

    $href = '#!';
    if (!$hasChildren) {
        if ($menu->route_name && \Illuminate\Support\Facades\Route::has($menu->route_name)) {
            $href = route($menu->route_name);
        } elseif ($menu->url) {
            $href = $menu->url;
        }
    }
@endphp

<li class="nav-item">
    <a class="nav-link {{ $hasChildren ? 'has-arrow' : '' }}"
        href="{{ $href }}"
        @if($hasChildren)
            data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}"
        @endif
    >
        @if($menu->icon)
            <i data-feather="{{ $menu->icon }}" class="nav-icon icon-xs me-2"></i>
        @endif
        {{ $menu->name }}
    </a>

    @if($hasChildren)
        <div id="{{ $collapseId }}" class="collapse" data-bs-parent="#sideNavbar">
            <ul class="nav flex-column">
                @foreach($menu->children as $child)
                    @include('layouts.partials.admin.menu-item', ['menu' => $child])
                @endforeach
            </ul>
        </div>
    @endif
</li>
