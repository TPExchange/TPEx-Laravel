<x-layout>
    <h3 class="text-center text-4xl mb-10">Your Orders</h3>

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
                Your Buy Orders Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Your Buy Orders
            @endif
        </x-section-header>

        <div class="flex gap-3 mb-2 p-5 flex-wrap">
            @php
                $buy_disp = array();
                foreach($buy_orders as $id => $order) {
                    $name = $order["asset"];
                    $nicename = ucwords(str_replace("_", " ", $name));
                    $count = $order["amount_remaining"];
                    $price = $order["coins"];
                    array_push($buy_disp, ["count"=>$count, "price"=>$price, "name"=>$name, "nicename"=>$nicename, "id" => $id]);
                }
                usort($buy_disp, function($a, $b) { return $b["id"] - $a["id"]; })
            @endphp
            @foreach ($buy_disp as $order)
                <x-order-panel item_name="{{ $order['nicename'] }}" name="{{ $order['name'] }}" count="{{ $order['count'] }}" price="{{ $order['price'] }}" id="{{ $order['id'] }}" :$restricted/>
            @endforeach
        </div>
    </div>


    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Your Sell Orders Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Your Sell Orders
            @endif
        </x-section-header>

        <div class="flex gap-3 mb-2 p-5 flex-wrap">
            @php
                $sell_disp = array();
                foreach($sell_orders as $id => $order) {
                    $name = $order["asset"];
                    $nicename = ucwords(str_replace("_", " ", $name));
                    $count = $order["amount_remaining"];
                    $price = $order["coins"];
                    array_push($sell_disp, ["count"=>$count, "price"=>$price, "name"=>$name, "nicename"=>$nicename, "id" => $id]);
                }
                usort($sell_disp, function($a, $b) { return $b["id"] - $a["id"]; })
            @endphp
            @foreach ($sell_disp as $order)
                <x-order-panel item_name="{{ $order['nicename'] }}" name="{{ $order['name'] }}" count="{{ $order['count'] }}" price="{{ $order['price'] }}" id="{{ $order['id'] }}" :$restricted/>
            @endforeach
        </div>
    </div>
</x-layout>
