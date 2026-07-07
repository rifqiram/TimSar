<header class="sticky top-0 bg-white shadow-sm border-b border-gray-200 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">
            
            <!-- Header: Left side -->
            <div class="flex items-center">
                <span class="font-extrabold text-xl text-slate-800 tracking-tight hidden md:block">{{ config('app.name', 'TimSar') }}</span>
                <!-- Hamburger button for mobile (placeholder) -->
                <button class="md:hidden text-gray-500 hover:text-gray-600" aria-controls="sidebar" aria-expanded="false">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2" />
                        <rect x="4" y="11" width="16" height="2" />
                        <rect x="4" y="17" width="16" height="2" />
                    </svg>
                </button>
            </div>

            <!-- i -->

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">
                <!-- User Menu -->
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
                    <!-- Dropdown Placeholder (dikelola CSS/JS nanti) -->
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
