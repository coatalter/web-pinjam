<!-- Admin Sidebar -->
<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-navy-500 transform transition-transform duration-300 lg:translate-x-0 shadow-xl lg:shadow-none"
    :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'" @click.outside="mobileMenu = false">

    <!-- Brand -->
    <div class="flex items-center gap-3 px-6 h-16 border-b border-navy-400/30">
        <div class="w-8 h-8 rounded-lg bg-navy-700 flex items-center justify-center border border-gold-400/40">
            <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                </path>
            </svg>
        </div>
        <span class="text-lg font-extrabold text-white tracking-tight">PinRuang</span>
        <span class="ml-auto text-[10px] font-bold bg-gold-500 text-navy-900 px-1.5 py-0.5 rounded">ADMIN</span>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        @foreach(($dynamicMenus ?? collect()) as $menu)
            @include('layouts.partials.admin.menu-item', ['menu' => $menu])
        @endforeach
    </nav>
</aside>

<!-- Mobile overlay -->
<div x-show="mobileMenu" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden"
    @click="mobileMenu = false"></div>