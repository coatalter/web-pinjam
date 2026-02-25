@php
    $paddingClass = $depth == 0 ? 'p-4' : 'p-3 pl-12 bg-slate-50/50 border-t border-slate-100';
@endphp

<li class="relative border-b border-slate-100 last:border-0 group transition-colors">
    <div
        class="{{ $paddingClass }} flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-slate-50/80 transition-colors">
        <div class="flex items-center gap-4">
            <!-- Icon/Indicator -->
            @if($depth == 0)
                <div
                    class="w-10 h-10 rounded-xl {{ $menu->is_active ? 'bg-indigo-50 border-indigo-100 text-indigo-500' : 'bg-slate-100 border-slate-200 text-slate-400' }} border flex items-center justify-center shadow-sm">
                    @if($menu->icon)
                        <i data-feather="{{ $menu->icon }}" class="w-5 h-5"></i>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
            @else
                <div class="w-6 h-6 flex items-center justify-center text-slate-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            @endif

            <!-- Info -->
            <div>
                <div class="flex items-center gap-2">
                    <strong class="{{ $depth == 0 ? 'text-base text-slate-800' : 'text-sm text-slate-700' }} font-bold">
                        {{ $menu->name }}
                    </strong>
                    @if(!$menu->is_active)
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100 uppercase tracking-widest">
                            Inactive
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-3 mt-1 text-xs font-medium text-slate-500">
                    @if($menu->route_name)
                        <span class="inline-flex items-center gap-1 font-mono bg-slate-100 px-1.5 py-0.5 rounded">
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                            {{ $menu->route_name }}
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        Urutan: {{ $menu->sort_order }}
                    </span>

                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        {{ $menu->roles->count() }} Role
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.menus.edit', $menu->id) }}"
                class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 transition-colors focus:ring-2 focus:ring-amber-400 focus:outline-none"
                title="Edit Menu">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </a>
            <button type="button"
                class="p-2 rounded-lg text-rose-500 hover:bg-rose-50 transition-colors focus:ring-2 focus:ring-rose-400 focus:outline-none"
                title="Hapus Menu"
                onclick="confirmDelete('{{ $menu->name }}', '{{ route('admin.menus.destroy', $menu->id) }}')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Recursive Call for Children -->
    @if($menu->children->count())
        <ul class="block w-full border-t border-slate-100">
            @foreach($menu->children as $child)
                @include('admin.menus.partials.menu-item', ['menu' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif
</li>