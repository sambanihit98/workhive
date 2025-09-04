@props(['label', 'name'])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => 'border border-black/20 text-sm rounded-lg block w-full p-2.5 bg-black/3 hover:border-[color:#1a2e44] transition-colors duration-300'
    ];
@endphp

<x-forms.field :$label :$name>
    <select {{ $attributes($defaults) }}>
        {{ $slot }}
    </select>
</x-forms.field>

