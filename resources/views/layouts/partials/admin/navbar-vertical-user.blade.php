<!-- User Sidebar -->
<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-navy-500 transform transition-transform duration-300 lg:translate-x-0 shadow-xl lg:shadow-none"
    :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'" @click.outside="mobileMenu = false">

    <!-- Brand -->
    <div class="flex items-center gap-3 px-6 h-16 border-b border-navy-400/30">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center">
            @include('layouts.partials.admin.logo')
        </div>
        <span class="text-lg font-extrabold text-white tracking-tight">Si-Labu</span>
        <span class="ml-auto text-[10px] font-bold bg-navy-200 text-navy-800 px-1.5 py-0.5 rounded">USER</span>
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
