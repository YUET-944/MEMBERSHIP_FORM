/**
 * Real-time Form Validation
 * Provides instant feedback for form fields
 */

class FormValidator {
    constructor(formId) {
        this.form = document.getElementById(formId);
        if (!this.form) return;
        
        this.init();
    }

    init() {
        // Add validation listeners to all inputs
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            // Real-time validation on blur
            input.addEventListener('blur', () => this.validateField(input));
            
            // Clear errors on input
            input.addEventListener('input', () => {
                if (input.classList.contains('invalid')) {
                    this.clearFieldError(input);
                }
            });
        });

        // Form submission validation
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                this.showFormErrors();
            }
        });
    }

    validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required';
        }

        // Email validation
        if (fieldName === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address';
            }
        }

        // CNIC validation
        if (fieldName === 'cnic' && value) {
            const cnicRegex = /^\d{5}-\d{7}-\d{1}$/;
            if (!cnicRegex.test(value)) {
                isValid = false;
                errorMessage = 'CNIC must be in format: 12345-1234567-1';
            }
        }

        // Phone validation
        if (fieldName === 'phone' && value) {
            if (value.length !== 9) {
                isValid = false;
                errorMessage = 'Phone number must be 9 digits';
            }
        }

        // URL validation
        if (field.type === 'url' && value) {
            try {
                new URL(value);
            } catch {
                isValid = false;
                errorMessage = 'Please enter a valid URL';
            }
        }

        // Date validation (must be in the past)
        if (field.type === 'date' && value) {
            const selectedDate = new Date(value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (selectedDate >= today) {
                isValid = false;
                errorMessage = 'Date of birth must be in the past';
            }
        }

        // Update field state
        if (isValid) {
            this.setFieldValid(field);
        } else {
            this.setFieldInvalid(field, errorMessage);
        }

        return isValid;
    }

    setFieldValid(field) {
        field.classList.remove('invalid', 'border-accent-coral');
        field.classList.add('valid', 'border-accent-green');
        
        // Remove error message
        this.clearFieldError(field);
        
        // Add check icon
        this.addValidationIcon(field, 'check', 'accent-green');
    }

    setFieldInvalid(field, message) {
        field.classList.remove('valid', 'border-accent-green');
        field.classList.add('invalid', 'border-accent-coral');
        
        // Remove success icon
        this.removeValidationIcon(field, 'check');
        
        // Add error icon
        this.addValidationIcon(field, 'x-circle', 'accent-coral');
        
        // Show error message
        this.showFieldError(field, message);
    }

    clearFieldError(field) {
        const errorElement = field.parentElement.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
    }

    showFieldError(field, message) {
        // Remove existing error
        this.clearFieldError(field);
        
        // Create error element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error mt-1 text-sm text-accent-coral flex items-center gap-1';
        errorDiv.innerHTML = `
            <i data-lucide="alert-circle" class="w-4 h-4"></i>
            <span>${message}</span>
        `;
        
        // Insert after field
        field.parentElement.appendChild(errorDiv);
        
        // Initialize Lucide icons
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    addValidationIcon(field, iconName, color) {
        // Remove existing icon
        this.removeValidationIcon(field, iconName);
        
        const iconDiv = document.createElement('div');
        iconDiv.className = `validation-icon-${iconName} absolute right-3 top-1/2 transform -translate-y-1/2 text-${color}`;
        iconDiv.innerHTML = `<i data-lucide="${iconName}" class="w-5 h-5"></i>`;
        
        field.parentElement.style.position = 'relative';
        field.parentElement.appendChild(iconDiv);
        
        // Initialize Lucide icons
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    removeValidationIcon(field, iconName) {
        const icon = field.parentElement.querySelector(`.validation-icon-${iconName}`);
        if (icon) {
            icon.remove();
        }
    }

    validateForm() {
        const inputs = this.form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    showFormErrors() {
        const firstInvalidField = this.form.querySelector('.invalid');
        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalidField.focus();
            
            if (window.toast) {
                window.toast.error('Please fix the errors in the form before submitting');
            }
        }
    }
}

// Auto-initialize for forms with data-validate attribute
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        new FormValidator(form.id);
    });
});

// Export for manual initialization
window.FormValidator = FormValidator;

