@props([
    'name' => 'otp',
    'length' => 6,
    'error' => null,
])

<div class="mb-6" x-data="{
    digits: Array({{ $length }}).fill(''),
    inputs: [],
    init() {
        this.inputs = Array.from(this.$refs.container.children);
    },
    handleInput(index, event) {
        const value = event.target.value.replace(/\D/g, '').slice(0, 1);
        this.digits[index] = value;
        event.target.value = value;
        
        if (value && index < this.inputs.length - 1) {
            this.inputs[index + 1].focus();
        }
    },
    handleKeydown(index, event) {
        if (event.key === 'Backspace' && !this.digits[index] && index > 0) {
            this.inputs[index - 1].focus();
        }
    },
    handlePaste(event) {
        const paste = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, {{ $length }});
        paste.split('').forEach((char, i) => {
            if (i < this.digits.length) {
                this.digits[i] = char;
                this.inputs[i].value = char;
            }
        });
        if (paste.length > 0) {
            this.inputs[Math.min(paste.length, this.inputs.length - 1)].focus();
        }
        event.preventDefault();
    }
}">
    <label class="block text-sm font-semibold text-charcoal mb-2">OTP Code</label>
    <div class="flex justify-center space-x-2" x-ref="container" @paste.prevent="handlePaste($event)">
        @for($i = 0; $i < $length; $i++)
            <input
                type="text"
                name="{{ $name }}[]"
                x-model="digits[{{ $i }}]"
                @input="handleInput({{ $i }}, $event)"
                @keydown="handleKeydown({{ $i }}, $event)"
                maxlength="1"
                class="w-12 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-input focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                :class="$error ? 'border-red-500 focus:ring-red-500' : ''"
            />
        @endfor
    </div>
    <input type="hidden" name="{{ $name }}" x-bind:value="digits.join('')">
    
    @if($error)
        <p class="mt-2 text-sm text-red-600 text-center">{{ $error }}</p>
    @endif
</div>

