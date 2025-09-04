@props(['required' => true, 'label', 'name'])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => 'text-sm rounded-lg block w-full p-2.5 border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-300',
        'value' => old($name)
    ];
@endphp

<x-forms.field :$label :$name :$required>
    <textarea rows="5" {{ $attributes($defaults) }}>{{ old($name, $slot) }}</textarea>
</x-forms.field>

