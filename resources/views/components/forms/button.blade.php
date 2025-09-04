@props(['element' => 'button', 'color' => false])

@if ($element == 'button')
    <div class="flex justify-end ">
        <button {{ $attributes->merge(
            ['class' => ($color === 'success' ? 'bg-green-600 hover:bg-green-800 ' : 
                        ($color === 'danger' ? 'bg-red-600 hover:bg-red-800 ' : 
                        ($color === 'warning' ? 'bg-yellow-600 hover:bg-yellow-800 ' : 
                        ($color === 'primary' ? 'bg-blue-600 hover:bg-blue-800 ' : 'bg-[color:#1a2e44] ')))) 
            . 'flex items-center gap-x-2 rounded py-2 px-3 font-bold text-white cursor-pointer text-sm transition-colors duration-300']) }}>{{ $slot }}</button>
    </div>
@endif

@if ($element == 'anchor')
    <div class="flex justify-end ">
        <a {{ $attributes->merge(
            ['class' => ($color === 'success' ? 'bg-green-600 hover:bg-green-800 ' : 
                        ($color === 'danger' ? 'bg-red-600 hover:bg-red-800 ' : 
                        ($color === 'warning' ? 'bg-yellow-600 hover:bg-yellow-800 ' : 
                        ($color === 'primary' ? 'bg-blue-600 hover:bg-blue-800 ' : 'bg-[color:#1a2e44] '))))
            . 'flex items-center gap-x-2 rounded py-2 px-3 font-bold text-white cursor-pointer text-sm transition-colors duration-300 ']) }}>{{ $slot }}</a>
    </div>
@endif

@if ($element == 'cancel')
    <div class="flex justify-end ">
        <a {{ $attributes->merge(['class' => 'bg-gray-300 rounded py-2 px-3 font-bold cursor-pointer text-sm ']) }}>{{ $slot }}</a>
    </div>
@endif
