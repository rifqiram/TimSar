<div id="sidebar" class="flex flex-col z-40 h-screen overflow-y-auto no-scrollbar w-64 shrink-0 bg-slate-800 p-4 hidden md:block">
    <!-- Sidebar header -->
    <div class="flex justify-between items-center pr-3 sm:px-2 mb-6">
        <!-- Logo -->
        <a class="block text-white font-bold text-2xl" href="{{ route('user.dashboard') }}">
            Logo Sistem
        </a>
    </div>

    <!-- Links -->
    <div class="space-y-8">
        <div>
            <h3 class="text-xs uppercase text-slate-400 font-semibold pl-3 mb-3">Menu Utama</h3>
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 {{ request()->routeIs('user.dashboard') ? 'bg-slate-700' : 'hover:bg-slate-700' }}">
                    <a class="block text-gray-300 hover:text-white truncate transition duration-150 {{ request()->routeIs('user.dashboard') ? 'text-blue-400 font-bold' : '' }}" href="{{ route('user.dashboard') }}">
                        <div class="flex items-center">
                            <span class="text-sm font-medium ml-3">Dashboard</span>
                        </div>
                    </a>
                </li>
                
                <!-- Data Diri -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 {{ request()->routeIs('user.profile*') ? 'bg-slate-700' : 'hover:bg-slate-700' }}">
                    <a class="block text-gray-300 hover:text-white truncate transition duration-150 {{ request()->routeIs('user.profile*') ? 'text-blue-400 font-bold' : '' }}" href="{{ route('user.profile') }}">
                        <div class="flex items-center">
                            <span class="text-sm font-medium ml-3">Data Diri</span>
                        </div>
                    </a>
                </li>
                
                <!-- Pelatihan -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 {{ request()->routeIs('user.training*') ? 'bg-slate-700' : 'hover:bg-slate-700' }}">
                    <a class="block text-gray-300 hover:text-white truncate transition duration-150 {{ request()->routeIs('user.training*') ? 'text-blue-400 font-bold' : '' }}" href="{{ route('user.training') }}">
                        <div class="flex items-center">
                            <span class="text-sm font-medium ml-3">Pelatihan</span>
                        </div>
                    </a>
                </li>

                <!-- Rekomendasi -->
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 {{ request()->routeIs('user.recommendation*') ? 'bg-slate-700' : 'hover:bg-slate-700' }}">
                    <a class="block text-gray-300 hover:text-white truncate transition duration-150 {{ request()->routeIs('user.recommendation*') ? 'text-blue-400 font-bold' : '' }}" href="{{ route('user.recommendation') }}">
                        <div class="flex items-center">
                            <span class="text-sm font-medium ml-3">Rekomendasi</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
