<header class="sticky top-0 bg-white dark:bg-slate-800 shadow-sm border-b border-gray-200 dark:border-slate-700 z-30 transition-colors duration-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">
            
            <div class="flex items-center">
                <span class="font-extrabold text-xl text-slate-800 dark:text-white tracking-tight hidden md:block">@yield('title', config('app.name', 'TimSar'))</span>
                
                <button class="md:hidden text-gray-500 hover:text-gray-600" aria-controls="sidebar" aria-expanded="false">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2" />
                        <rect x="4" y="11" width="16" height="2" />
                        <rect x="4" y="17" width="16" height="2" />
                    </svg>
                </button>
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">
                
                <!-- Dark mode toggle -->
                <button id="darkModeToggle" class="text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300 transition-colors p-2 rounded-lg bg-slate-100 dark:bg-slate-800">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>

                <div class="relative inline-flex" id="userMenuContainer">
                    <button id="userMenuBtn" class="inline-flex justify-center items-center group hover:bg-slate-50 px-3 py-2 rounded-lg transition-colors duration-200">
                        <img class="w-8 h-8 rounded-full bg-gray-200" id="navUserAvatar" src="https://ui-avatars.com/api/?name=User&background=random" width="32" height="32" alt="User" />
                        <div class="flex items-center truncate">
                            <span class="truncate ml-2 text-sm font-semibold text-slate-600 group-hover:text-slate-900" id="navUserName">User</span>
                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" viewBox="0 0 12 12">
                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                            </svg>
                        </div>
                    </button>
                    <div id="userMenuDropdown" class="hidden absolute right-0 top-full mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden py-2 ring-1 ring-black ring-opacity-5">
                        <ul>
                            <li>
                                <a class="font-medium text-sm text-slate-600 hover:text-indigo-600 hover:bg-slate-50 flex items-center py-2 px-4 transition-colors" href="{{ route('user.profile') }}">Profile</a>
                            </li>
                            <li>
                                <button type="button" onclick="handleLogout()" class="font-medium text-sm text-red-500 hover:text-red-600 hover:bg-red-50 flex items-center py-2 px-4 w-full text-left transition-colors">Logout</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>

<script>
    // Dark mode logic
    const toggleBtn = document.getElementById('darkModeToggle');
    const html = document.documentElement;
    
    // Check local storage or system preference
    if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    }
    
    toggleBtn.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('darkMode', html.classList.contains('dark'));
    });
</script>
