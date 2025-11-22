import './bootstrap';
import './toast';

// CNIC Formatting
function formatCNIC(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 5) {
        value = value.substring(0, 5) + '-' + value.substring(5);
    }
    if (value.length > 13) {
        value = value.substring(0, 13) + '-' + value.substring(13, 14);
    }
    input.value = value;
}

// Phone Number Formatting
function formatPhone(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 9) {
        value = value.substring(0, 9);
    }
    input.value = value;
}

// File Upload Preview
function setupFileUpload(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    if (input && preview) {
        input.addEventListener('change', function(e) {
            if (e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', function() {
    // CNIC formatting
    const cnicInput = document.getElementById('cnic');
    if (cnicInput) {
        cnicInput.addEventListener('input', () => formatCNIC(cnicInput));
    }
    
    // Phone formatting
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', () => formatPhone(phoneInput));
    }
    
    // File uploads
    setupFileUpload('profilePicture', 'profilePreview');
});

// Import form validation
import './form-validation';

// Export for use in other scripts
window.formatCNIC = formatCNIC;
window.formatPhone = formatPhone;

