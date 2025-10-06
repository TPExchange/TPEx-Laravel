<x-layout>
    <h3 class="text-center text-4xl mb-10">{{ $username }}'s Inventory</h3>

    <x-search action="/inventory/search"></x-search>



    <section class="relative">
        <div class="absolute -top-10 flex items-center">
            <h3 class="text-xl px-3 py-1 rounded-lg">TPEx coins: <span class="font-bold">{{ new \TPEx\TPEx\Coins($coins)->pretty() }}</span></h3>
        </div>
        <div class="bg-neutral-100 rounded-lg pb-5">
            <x-section-header>
                @if (request("q"))
                    Results For: "{{ htmlspecialchars(request("q")) }}"
                @else
                    Player's Items
                @endif
            </x-section-header>
            <div class="flex gap-3 mb-2 p-5 flex-wrap">
                @foreach (array_keys($inventory) as $item)
                    <x-item-panel item_name="{{ ucwords(str_replace('_', ' ', $item)) }}" name="{{ $item }}" count="{{ $inventory[$item] }}" :$restricted/>
                @endforeach
            </div>
        </div>
    </section>

</x-layout>
