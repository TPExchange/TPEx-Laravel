<x-layout>
    <h3 class="text-center text-4xl mb-10">All Items</h3>

    <x-search action="/items/search"></x-search>

    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Buy Orders Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Buy Orders
            @endif
        </x-section-header>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3 mb-2">
        @foreach (array_keys($buy_orders) as $name)
            @php
                $nicename = ucwords(str_replace("_", " ", $name));
                $count = 100;
                $game_id = "minecraft_" . $name;
                // $item_id = $item->id;
            @endphp
            {{-- <x-item-panel item_name="{{ $name }}" count="{{ $count }}" game_id="{{ $game_id }}" item_id="{{ $item_id }}" for_sale="{{ $for_sale }}"></x-item-panel> --}}
            <x-item-panel item_name="{{ $nicename }}" game_id="{{ $game_id }}" count="{{ $count }}"/>
        @endforeach
        </div>
    </div>

    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Sell Order Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Sell Orders
            @endif
        </x-section-header>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3 mb-2">
        @foreach (array_keys($sell_orders) as $name)
            @php
                $nicename = ucwords(str_replace("_", " ", $name));
                $count = 100;
                $game_id = "minecraft_" . $name;
                // $item_id = $item->id;
            @endphp
            {{-- <x-item-panel item_name="{{ $name }}" count="{{ $count }}" game_id="{{ $game_id }}" item_id="{{ $item_id }}" for_sale="{{ $for_sale }}"></x-item-panel> --}}
            <x-item-panel item_name="{{ $nicename }}" game_id="{{ $game_id }}" count="{{ $count }}"/>
        @endforeach
        </div>
    </div>

</x-layout>