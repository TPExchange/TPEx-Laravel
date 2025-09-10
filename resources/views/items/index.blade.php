<x-layout>
    <h3 class="text-center text-4xl mb-10">All Items</h3>

    <x-search action="/items/search"></x-search>

    <a href="/items/buy" class="flex m-auto text-center w-fit bg-blue-400 hover:bg-blue-500 text-white duration-300 px-3 py-1 rounded-full text-xl cursor-pointer">Place Buy Order</a>

    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Items For Sale Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Items For Sale
            @endif
        </x-section-header>

        <div class="flex gap-3 mb-2 p-5">
        @foreach ($sell_orders as $name => $prices)
            @php
                $nicename = ucwords(str_replace("_", " ", $name));
                $count = 0;
                foreach ($prices as $price=>$orders) {
                    foreach ($orders as $order) {
                        $count += $order["amount_remaining"];
                    }
                }
                $price = array_keys($prices)[0];
            @endphp
            @if ($count > 0)
                <x-item-panel item_name="{{ $nicename }}" name="{{ $name }}" count="{{ $count }}" price="{{ $price }}" :$restricted/>
            @endif
        @endforeach
        </div>
    </div>

    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Items In Demand Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Items In Demand
            @endif
        </x-section-header>

        <div class="flex gap-3 mb-2 p-5">
        @foreach ($buy_orders as $name => $prices)
            @php
                $nicename = ucwords(str_replace("_", " ", $name));
                $count = 0;
                foreach ($prices as $price=>$orders) {
                    foreach ($orders as $order) {
                        $count += $order["amount_remaining"];
                    }
                }
            @endphp
            @if ($count > 0)
                <x-item-panel item_name="{{ $nicename }}" name="{{ $name }}" count="{{ $count }}" price="{{ $price }}" :$restricted/>
            @endif
        @endforeach
        </div>
    </div>



</x-layout>
