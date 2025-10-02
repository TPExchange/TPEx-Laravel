<x-layout>
    <h3 class="text-center text-4xl mb-10">Trade Items</h3>

    <x-search action="/items/search"></x-search>

    <a href="/items/buy" class="flex m-auto text-center w-fit bg-blue-400 hover:bg-blue-500 text-white duration-300 px-3 py-1 rounded-full text-xl cursor-pointer">Place Buy Order</a>

    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Items In Demand Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Items In Demand
            @endif
        </x-section-header>

        <div class="flex gap-3 mb-2 p-5 flex-wrap">
        @php
            $buy_disp = array();
            foreach($buy_orders as $name => $prices) {
                $nicename = ucwords(str_replace("_", " ", $name));
                $count = 0;
                $best_order = 0;
                $best_price = array_key_last($prices);
                foreach ($prices as $price=>$orders) {
                    foreach ($orders as $order) {
                        if ($best_price == $price) {
                            $best_order = max($best_order, $order["id"]);
                        }
                        $count += $order["amount_remaining"];
                    }
                }
                array_push($buy_disp, ["count"=>$count, "price"=>$best_price, "name"=>$name, "nicename"=>$nicename, "best_order" => $best_order]);
            }
            usort($buy_disp, function($a, $b) { return $b["best_order"] - $a["best_order"]; })
        @endphp
        @foreach ($buy_disp as $elem)
            @if ($count > 0)
                <x-item-panel item_name="{{ $elem['nicename'] }}" name="{{ $elem['name'] }}" count="{{ $elem['count'] }}" price="{{ $elem['price'] }}" :$restricted/>
            @endif
        @endforeach
        </div>
    </div>


    <div class="bg-neutral-100 rounded-lg my-10">
        <x-section-header>
            @if (request("q"))
                Items For Sale Matching: "{{ htmlspecialchars(request("q")) }}"
            @else
                Items For Sale
            @endif
        </x-section-header>

        <div class="flex gap-3 mb-2 p-5 flex-wrap">
        @php
            $sell_disp = array();
            foreach($sell_orders as $name => $prices) {
                $nicename = ucwords(str_replace("_", " ", $name));
                $count = 0;
                $best_order = 0;
                $best_price = array_key_first($prices);
                foreach ($prices as $price=>$orders) {
                    foreach ($orders as $order) {
                        if ($best_price == $price) {
                            $best_order = max($best_order, $order["id"]);
                        }
                        $count += $order["amount_remaining"];
                    }
                }
                array_push($sell_disp, ["count"=>$count, "price"=>$best_price, "name"=>$name, "nicename"=>$nicename, "best_order" => $best_order]);
            }
            usort($sell_disp, function($a, $b) { return $b["best_order"] - $a["best_order"]; })
        @endphp
        @foreach ($sell_disp as $elem)
            @if ($count > 0)
                <x-item-panel item_name="{{ $elem['nicename'] }}" name="{{ $elem['name'] }}" count="{{ $elem['count'] }}" price="{{ $elem['price'] }}" :$restricted/>
            @endif
        @endforeach
        </div>
    </div>

</x-layout>
