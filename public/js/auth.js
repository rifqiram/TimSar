/**
 * Auth Module for API-First Blade Views
 * Handles token storage, redirection logic, and API calls.
 */
const Auth = {
    /**
     * Get the API Base URL from the global scope (defined in layout)
     */
    getApiBase() {
        return window.apiBase || '/api';
    },

    /**
     * Store authentication data in LocalStorage
     */
    setSession(token, user) {
        if (token) localStorage.setItem('api_token', token);
        if (user) localStorage.setItem('api_user', JSON.stringify(user));
    },

    /**
     * Retrieve current authentication token
     */
    getToken() {
        return localStorage.getItem('api_token');
    },

    /**
     * Retrieve current authenticated user object
     */
    getUser() {
        try {
            const user = localStorage.getItem('api_user');
            return user ? JSON.parse(user) : null;
        } catch (e) {
            return null;
        }
    },

    /**
     * Clear the authentication session
     */
    clearSession() {
        localStorage.removeItem('api_token');
        localStorage.removeItem('api_user');
    },

    /**
     * Redirect logic based on user role
     */
    redirectBasedOnRole(user) {
        if (!user || !user.role) return;
        
        const targetUrl = user.role === 'admin' ? '/admin/dashboard' : '/user/dashboard';
        if (window.location.pathname !== targetUrl) {
            window.location.href = targetUrl;
        }
    },

    /**
     * Check if user is logged in. If yes, fetch fresh data and redirect.
     * Use this on guest pages (Login/Register)
     */
    async redirectIfLoggedIn() {
        const token = this.getToken();
        let user = this.getUser();

        if (!token) return;

        // Fast redirect if we already have user data in local storage
        if (user && user.role) {
            this.redirectBasedOnRole(user);
            return;
        }

        // Verify token with backend if we don't have user data
        try {
            const response = await fetch(this.getApiBase() + '/me', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                },
            });
            
            if (response.ok) {
                const payload = await response.json();
                user = payload.data?.user ?? payload.user;
                this.setSession(null, user); // update user data only
                this.redirectBasedOnRole(user);
            } else {
                // Token is invalid or expired
                this.clearSession();
            }
        } catch (error) {
            console.error('Auth check failed:', error);
        }
    },

    /**
     * Execute a Login Request
     */
    async login(email, password) {
        const response = await fetch(this.getApiBase() + '/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Login gagal.');
        }

        return data;
    },

    /**
     * Execute a Register Request
     */
    async register(userData) {
        const response = await fetch(this.getApiBase() + '/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(userData),
        });

        const data = await response.json();

        if (!response.ok) {
            // Handle validation errors formatting
            if (data.errors) {
                const firstErrorKey = Object.keys(data.errors)[0];
                throw new Error(data.errors[firstErrorKey][0]);
            }
            throw new Error(data.message || 'Registrasi gagal.');
        }

        return data;
    },

    /**
     * Handle UI Loading States
     */
    setLoadingState(buttonElement, isLoading, originalText = 'Submit') {
        if (!buttonElement) return;
        
        buttonElement.disabled = isLoading;
        
        if (isLoading) {
            buttonElement.innerHTML = `
                <div class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </div>
            `;
        } else {
            buttonElement.innerHTML = originalText;
        }
    }
};

window.Auth = Auth;
