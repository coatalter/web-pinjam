@if($menu->children && $menu->children->count() > 0)
    {{-- Parent menu with children --}}
    <div
        x-data="{ open: {{ request()->routeIs(collect($menu->children)->pluck('route_name')->filter()->map(fn($r) => $r . '*')->join(',')) ? 'true' : 'false' }} }">
        <button @click="open = !open"
            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-navy-100 hover:text-white hover:bg-navy-400/40 transition-all group">
            <span class="flex items-center gap-3">
                @if($menu->icon)
                    <i data-feather="{{ $menu->icon }}" class="w-[18px] h-[18px] text-navy-200 group-hover:text-gold-400"></i>
                @endif
                <span>{{ $menu->name }}</span>
            </span>
            <svg class="w-4 h-4 text-navy-300 transition-transform duration-200" :class="open && 'rotate-90'" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="open" x-collapse class="ml-4 mt-0.5 space-y-0.5 border-l-2 border-navy-400/30 pl-3">
            @foreach($menu->children as $child)
                @include('layouts.partials.admin.menu-item', ['menu' => $child])
            @endforeach
        </div>
    </div>
@else
    {{-- Single menu item --}}
    @php
        $href = '#';
        $isActive = false;
        if ($menu->route_name && \Illuminate\Support\Facades\Route::has($menu->route_name)) {
            $href = route($menu->route_name);
            $isActive = request()->routeIs($menu->route_name . '*');
        } elseif ($menu->url ?? false) {
            $href = $menu->url;
        }
    @endphp
    <a href="{{ $href }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ $isActive ? 'bg-gold-500 text-navy-900 shadow-sm' : 'text-navy-100 hover:text-white hover:bg-navy-400/40' }}">
        @if($menu->icon)
            <i data-feather="{{ $menu->icon }}"
                class="w-[18px] h-[18px] {{ $isActive ? 'text-navy-700' : 'text-navy-200' }}"></i>
        @else
            <span class="w-1.5 h-1.5 rounded-full {{ $isActive ? 'bg-navy-700' : 'bg-navy-300' }}"></span>
        @endif
        <span>{{ $menu->name }}</span>
    </a>
@endif