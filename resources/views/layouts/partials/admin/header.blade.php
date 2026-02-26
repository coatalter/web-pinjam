<!-- Top Header -->
<header
    class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-slate-200/60 h-16 flex items-center justify-between px-6">
    <!-- Left: Mobile menu -->
    <div class="flex items-center gap-4">
        <button @click.stop="mobileMenu = !mobileMenu"
            class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-navy-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Right: User menu -->
    <div class="flex items-center gap-3" x-data="{ open: false }">
        <button @click.stop="open = !open"
            class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 transition-colors">
            <div
                class="w-8 h-8 rounded-full bg-gradient-to-br from-navy-500 to-navy-700 text-white flex items-center justify-center font-bold text-xs">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="hidden sm:block text-left">
                <p class="text-sm font-semibold text-slate-700 leading-tight">{{ Auth::user()->name }}</p>
                <p class="text-[11px] text-slate-400">{{ Auth::user()->role?->name ?? 'User' }}</p>
            </div>
            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown -->
        <div x-show="open" @click.outside="open = false" x-transition
            class="absolute right-6 top-14 w-56 bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 py-2 z-50">
            <div class="px-4 py-3 border-b border-slate-100">
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
            </div>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center gap-2 px-4 py-2.5 text-sm text-danger-600 hover:bg-danger-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>
</header>