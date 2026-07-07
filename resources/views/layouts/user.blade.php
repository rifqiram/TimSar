<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard') - {{ config('app.name', 'TimSar') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        window.apiBase = window.location.origin + '{{ request()->getBaseUrl() }}/api';
        window.getApiToken = function () { return localStorage.getItem('api_token'); };
        window.getApiUser = function () { const u = localStorage.getItem('api_user'); return u ? JSON.parse(u) : null; };
        window.clearApiToken = function () { localStorage.removeItem('api_token'); localStorage.removeItem('api_user'); };

        // Protect route
        if (!window.getApiToken() && !window.location.pathname.includes('/login') && !window.location.pathname.includes('/register')) {
            window.location.href = '/user/login';
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        @include('components.user.sidebar')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            @include('components.user.navbar')

            <main class="w-full grow p-6">
                @yield('content')
            </main>
            
            @include('components.user.footer')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const user = window.getApiUser();
            if (user && user.name) {
                const nameEls = document.querySelectorAll('#navUserName, #dashUserName');
                nameEls.forEach(el => el.textContent = user.name);
                
                const avatarEl = document.getElementById('navUserAvatar');
                if(avatarEl) avatarEl.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&background=random';
            }

        // Handle User Dropdown Toggle
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenuDropdown = document.getElementById('userMenuDropdown');
        
        if(userMenuBtn && userMenuDropdown) {
            userMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenuDropdown.classList.toggle('hidden');
            });
            
            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                    userMenuDropdown.classList.add('hidden');
                }
            });
        }

        });

        async function handleLogout() {
            const token = window.getApiToken();
            if (token) {
                try {
                    await fetch(window.apiBase + '/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    });
                } catch(e) {}
            }
            window.clearApiToken();
            window.location.href = '/user/login';
        }
    </script>
</body>
</html>