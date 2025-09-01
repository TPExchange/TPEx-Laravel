<x-layout>
    <h3 class="text-center text-4xl mb-10">All Items</h3>

    <x-search action="/items/search"></x-search>

        @if ($errors->any())
            <div class="bg-red-300 px-3 py-1 rounded-sm flex flex-col">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif


    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Your Sell Orders Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Your Sell Orders
            @endif
        </x-section-header>

        <div class="flex flex-wrap gap-3 mb-2">
        @foreach ($sell_orders as $id=>$order)
            @php
                $name = $order["asset"];
                $nicename = ucwords(str_replace("_", " ", $name));
                $count = $order["amount_remaining"];
                $price = $order["coins"];
            @endphp
            <x-order-panel item_name="{{ $nicename }}" name="{{ $name }}" count="{{ $count }}" price="{{ $price }}" id="{{ $id }}" :$restricted/>
        @endforeach
        </div>
    </div>

    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Your Buy Orders Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Your Buy Orders
            @endif
        </x-section-header>

        <div class="flex flex-wrap gap-3 mb-2">
        @foreach ($buy_orders as $id=>$order)
            @php
                $name = $order["asset"];
                $nicename = ucwords(str_replace("_", " ", $name));
                $count = $order["amount_remaining"];
                $price = $order["coins"];
            @endphp
            <x-order-panel item_name="{{ $nicename }}" name="{{ $name }}" count="{{ $count }}" price="{{ $price }}" id="{{ $id }}" :$restricted/>
        @endforeach
        </div>
    </div>



</x-layout>