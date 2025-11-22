@props([
    'name' => '',
    'label' => '',
    'required' => false,
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'error' => null,
])

<div class="mb-6" x-data="{ 
    isDragging: false,
    fileName: '',
    preview: null,
    handleFileSelect(event) {
        const file = event.target.files[0] || event.dataTransfer?.files[0];
        if (file) {
            this.fileName = file.name;
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => this.preview = e.target.result;
                reader.readAsDataURL(file);
            }
        }
    }
}">
    @if($label)
        <label class="block text-sm font-semibold text-charcoal mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div 
        @dragover.prevent="isDragging = true; $el.classList.add('dragging')"
        @dragleave.prevent="isDragging = false; $el.classList.remove('dragging')"
        @drop.prevent="isDragging = false; $el.classList.remove('dragging'); handleFileSelect($event)"
        class="ultra-file-upload"
        :class="isDragging ? 'dragging' : ''"
        @click="$refs.fileInput.click()"
    >
        <input
            type="file"
            name="{{ $name }}"
            x-ref="fileInput"
            accept="{{ $accept }}"
            {{ $required ? 'required' : '' }}
            class="hidden"
            @change="handleFileSelect($event)"
        />
        
        <div x-show="!preview" class="space-y-2">
            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
            <p class="text-sm text-gray-medium mb-1">
                <span class="text-primary font-semibold">Click to upload</span> or drag and drop
            </p>
            <p class="text-xs text-gray-medium">Max size: {{ $maxSize }}</p>
        </div>
        
        <div x-show="preview" class="space-y-3" style="display: none;">
            <img :src="preview" alt="Preview" class="max-h-40 mx-auto rounded-lg shadow-soft">
            <p class="text-sm font-medium text-charcoal" x-text="fileName"></p>
            <button type="button" @click.stop="$refs.fileInput.value = ''; preview = null; fileName = ''" class="text-xs text-red-600 hover:text-red-700 font-medium">Remove</button>
        </div>
    </div>
    
    @if($error)
        <p class="mt-2 text-sm text-red-600 flex items-center">
            <i class="fas fa-exclamation-circle mr-1.5"></i>
            {{ $error }}
        </p>
    @endif
</div>
