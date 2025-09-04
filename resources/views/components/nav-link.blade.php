 @props(['element' => 'anchor', 'active' => false, 'from' => false])
 
@if($element == "anchor")
    <a {{ $attributes->merge([
            'class' => ($active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white') 
            . ' rounded-md px-3 py-2 text-sm font-bold cursor-pointer' . 
            ($from === 'side-nav' ? ' block ms-3 flex gap-x-2 items-center' : ''), 'aria-current' => $active ? 'page' : 'false'
        ]) }}>
        {{ $slot }}
    </a>
@endif


 @if($element == "button")
        <button {{ $attributes->merge([
            'class' => 'cursor-pointer rounded-md px-3 py-2 text-sm font-bold hover:bg-gray-700 hover:text-white text-gray-300 ' 
            . ($from === 'side-nav' ? 'block w-full ms-3 flex gap-x-2 items-center ' : ' ')]) }}> {{ $slot }} </button>
 @endif