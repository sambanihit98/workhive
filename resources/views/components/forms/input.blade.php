@props(['required' => true, 'label', 'name'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => '
            w-full 
            px-4 py-3 
            
            rounded-xl 
            border border-gray-300 
            bg-white 
            text-gray-700 
            placeholder-gray-400 
            shadow-sm 
            focus:outline-none 
            focus:ring-2 
            focus:ring-blue-500 
            focus:border-blue-500 
            transition 
            duration-200
        ',
        'value' => old($name),
    ];
@endphp


<x-forms.field :$label :$name :$required>
    <input {{ $attributes($defaults) }}>
</x-forms.field>

