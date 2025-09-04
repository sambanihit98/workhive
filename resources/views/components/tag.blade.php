@props(['tag', 'size' => 'base'])

@php
    $classes = "cursor-pointer bg-gradient-to-r from-gray-100 to-gray-300 hover:from-gray-200 hover:to-gray-400 rounded-xl font-bold transition-colors duration-300";

    if($size == 'base'){
        $classes .= " text-sm px-3 py-1";
    }
    
    if($size == 'small') {
        $classes .= " text-[10px] px-3 py-1";
    }
@endphp

<a href="/tags/{{ strtolower($tag->name) }}" class="{{ $classes }}">{{ $tag->name }}</a>