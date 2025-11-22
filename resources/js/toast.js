/**
 * Toast Notification System
 * Usage: window.toast.success('Message'), window.toast.error('Message'), etc.
 */

class ToastManager {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        // Create toast container if it doesn't exist
        if (!document.getElementById('toast-container')) {
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            this.container.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(this.container);
        } else {
            this.container = document.getElementById('toast-container');
        }
    }

    show(message, type = 'info', duration = 5000) {
        const toast = document.createElement('div');
        const toastId = 'toast-' + Date.now();
        toast.id = toastId;

        const typeClasses = {
            success: 'bg-accent-green text-white border-accent-green',
            error: 'bg-accent-coral text-white border-accent-coral',
            warning: 'bg-yellow-400 text-dark border-yellow-400',
            info: 'bg-primary-green text-white border-primary-green',
        };

        const icons = {
            success: 'check-circle',
            error: 'x-circle',
            warning: 'alert-triangle',
            info: 'info',
        };

        toast.className = `bg-white rounded-lg shadow-2xl border-2 ${typeClasses[type]} p-4 flex items-center gap-3 min-w-[300px] max-w-md transform transition-all duration-300 translate-y-0 opacity-100`;
        toast.innerHTML = `
            <i data-lucide="${icons[type]}" class="w-6 h-6 flex-shrink-0"></i>
            <p class="flex-1 font-medium">${message}</p>
            <button onclick="this.closest('#${toastId}').remove()" class="flex-shrink-0 hover:opacity-75 transition-opacity">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        `;

        this.container.appendChild(toast);

        // Initialize Lucide icons
        if (window.lucide) {
            window.lucide.createIcons();
        }

        // Auto remove after duration
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    success(message, duration) {
        this.show(message, 'success', duration);
    }

    error(message, duration) {
        this.show(message, 'error', duration);
    }

    warning(message, duration) {
        this.show(message, 'warning', duration);
    }

    info(message, duration) {
        this.show(message, 'info', duration);
    }
}

// Initialize and expose globally
window.toast = new ToastManager();

// Auto-display Laravel flash messages
document.addEventListener('DOMContentLoaded', () => {
    // Check for Laravel flash messages
    const successMessage = document.querySelector('[data-flash-success]');
    const errorMessage = document.querySelector('[data-flash-error]');
    const warningMessage = document.querySelector('[data-flash-warning]');
    const infoMessage = document.querySelector('[data-flash-info]');

    if (successMessage) {
        window.toast.success(successMessage.textContent);
    }
    if (errorMessage) {
        window.toast.error(errorMessage.textContent);
    }
    if (warningMessage) {
        window.toast.warning(warningMessage.textContent);
    }
    if (infoMessage) {
        window.toast.info(infoMessage.textContent);
    }
});

