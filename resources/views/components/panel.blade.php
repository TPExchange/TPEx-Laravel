@props(["name", "restricted"])
@if (in_array($name, $restricted))
<div class="w-100 bg-red-300 p-2 rounded-sm border border-red-500">
@else
<div class="w-100 bg-white p-2 rounded-sm border border-neutral-700">
@endif
    {{ $slot }}
</div>
