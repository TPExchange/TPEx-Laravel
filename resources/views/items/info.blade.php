<x-layout>
    <h3 class="text-center text-4xl mb-10">{{ucwords(str_replace("_", " ", $asset))}} Information</h3>
    <x-item-info :$buy :$sell :$asset />
    <x-item-history :$history :$asset />
</x-layout>
