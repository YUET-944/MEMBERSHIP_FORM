<div class="upload-container">
    <img id="profilePreview" class="preview" alt="Profile preview">
    <input type="file" id="profileFileInput" class="file-input" accept="image/jpeg, image/png">
    <button type="button" class="upload-btn" onclick="document.getElementById('profileFileInput').click()">Choose Profile Picture</button>
    <div id="profileFileName" class="file-name"></div>
</div>

<style>
    .upload-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        max-width: 320px;
        margin: 1rem auto;
        padding: 1.25rem;
        border: 2px dashed rgba(30,77,43,0.12);
        border-radius: 12px;
        text-align: center;
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(6px);
    }
    
    .preview {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        display: none;
        border: 3px solid rgba(255,255,255,0.8);
        box-shadow: 0 8px 20px rgba(30,77,43,0.12);
    }
    
    .upload-btn {
        background-color: #1e4d2b; /* emerald */
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        transition: background-color 0.18s ease, transform 0.12s ease;
    }
    
    .upload-btn:hover { background-color: #24643a; transform: translateY(-2px); }
    
    .file-input { display: none; }
    
    .file-name { color: #4b5563; font-size: 13px; margin-top: 4px; word-break: break-word; }
    
    @media (max-width: 480px) {
        .upload-container { max-width: 90%; padding: 1rem; }
        .preview { width: 110px; height: 110px; }
    }
</style>

<script>
(function(){
    const fileInput = document.getElementById('profileFileInput');
    const preview = document.getElementById('profilePreview');
    const fileName = document.getElementById('profileFileName');

    if (!fileInput) return;

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validate file type
        const allowed = ['image/jpeg', 'image/png'];
        if (!allowed.includes(file.type)) {
            alert('Please select a JPG or PNG image file.');
            fileInput.value = '';
            return;
        }

        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            fileInput.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(evt) {
            preview.src = evt.target.result;
            preview.style.display = 'block';
            fileName.textContent = file.name;
        }
        reader.readAsDataURL(file);
    });
})();
</script>
