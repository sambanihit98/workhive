@props(['required' => true, 'name', 'label'])

<div class="inline-flex items-center gap-x-2 block text-sm font-medium">
    {{-- <span class="w-2 h-2 bg-white inline-block"></span> --}}
    <label class="font-bold" for="{{ $name }}">
        {{ $label }} 
        @if ($required == true)
          <span class="text-red-500 font-bold">*</span>
        @endif
    </label>
</div>
