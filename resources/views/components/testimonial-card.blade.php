<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex items-center">
        @if($testimonial->client_photo)
            <img class="w-12 h-12 rounded-full" src="{{ asset('storage/' . $testimonial->client_photo) }}" alt="{{ $testimonial->client_name }}">
        @else
            <div class="bg-gray-200 border-2 border-dashed rounded-full w-12 h-12 flex items-center justify-center">
                <span class="text-gray-500 text-xs">No Photo</span>
            </div>
        @endif
        
        <div class="ml-4">
            <h4 class="text-lg font-bold text-gray-900">{{ $testimonial->client_name }}</h4>
            <div class="flex mt-1">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $testimonial->rating)
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    
    <p class="mt-4 text-gray-600 italic">
        "{{ $testimonial->review }}"
    </p>
</div>