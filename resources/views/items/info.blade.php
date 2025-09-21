<x-layout>
    <h3 class="text-center text-4xl mb-10">{{ucwords(str_replace("_", " ", $item))}} Information</h3>
    <x-item-history :$history :$item />
    <x-item-info :$buy :$sell :$item />
</x-layout>
