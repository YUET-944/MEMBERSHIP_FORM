<div class="mb-6">
    <div class="flex justify-between mb-1">
        <span class="text-base font-medium text-gray-700">{{ $skill->name }}</span>
        <span class="text-sm font-medium text-gray-700">{{ $skill->level }}%</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $skill->level }}%"></div>
    </div>
    @if($skill->category)
        <div class="mt-1 text-sm text-gray-500">{{ $skill->category }}</div>
    @endif
</div>