<form {{ $attributes->merge(["class" => "mx-auto space-y-6"]) }}>
    @csrf
    {{ $slot }}
</form>