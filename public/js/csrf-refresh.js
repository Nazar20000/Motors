/**
 * CSRF Token Auto-Refresh Script
 * Prevents 419 errors by automatically refreshing CSRF tokens
 */

class CsrfTokenManager {
    constructor() {
        this.tokenRefreshInterval = 25 * 60 * 1000; // 25 minutes (before 30 min server limit)
        this.init();
    }

    init() {
        // Start token refresh timer
        this.startTokenRefresh();
        
        // Add event listeners for form submissions
        this.addFormListeners();
        
        // Refresh token on page visibility change
        this.addVisibilityListener();
    }

    startTokenRefresh() {
        setInterval(() => {
            this.refreshCsrfToken();
        }, this.tokenRefreshInterval);
    }

    async refreshCsrfToken() {
        try {
            const response = await fetch('/csrf-refresh', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                this.updateAllCsrfTokens(data.token);
                console.log('CSRF token refreshed successfully');
            }
        } catch (error) {
            console.warn('Failed to refresh CSRF token:', error);
        }
    }

    updateAllCsrfTokens(newToken) {
        // Update meta tag
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            metaTag.setAttribute('content', newToken);
        }

        // Update all hidden input fields
        const csrfInputs = document.querySelectorAll('input[name="_token"]');
        csrfInputs.forEach(input => {
            input.value = newToken;
        });

        // Update all forms with csrf_field()
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const formToken = form.querySelector('input[name="_token"]');
            if (formToken) {
                formToken.value = newToken;
            }
        });
    }

    addFormListeners() {
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (form.tagName === 'FORM') {
                // Ensure CSRF token is present before submission
                this.ensureCsrfToken(form);
                // Pause auto-refresh briefly to avoid race with submit
                this.pauseRefreshTemporarily();
            }
        });
    }

    ensureCsrfToken(form) {
        let csrfInput = form.querySelector('input[name="_token"]');
        
        if (!csrfInput) {
            // Create CSRF input if it doesn't exist
            csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = this.getCurrentToken();
            form.appendChild(csrfInput);
        }
    }

    getCurrentToken() {
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        return metaTag ? metaTag.getAttribute('content') : '';
    }

    addVisibilityListener() {
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                // Refresh token when page becomes visible
                this.refreshCsrfToken();
            }
        });
    }

    pauseRefreshTemporarily() {
        if (this._pausedTimer) clearTimeout(this._pausedTimer);
        const originalInterval = this.tokenRefreshInterval;
        this.tokenRefreshInterval = originalInterval + 60 * 1000; // add 1 minute
        this._pausedTimer = setTimeout(() => {
            this.tokenRefreshInterval = originalInterval;
        }, 90 * 1000);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new CsrfTokenManager();
});

// Export for use in other scripts
window.CsrfTokenManager = CsrfTokenManager;
