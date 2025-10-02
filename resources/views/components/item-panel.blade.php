@props(["item_name"=>"Item Name", "count"=>"0", "name"=>"cobblestone", "sys_id"=>"cobblestone", "price"=>null, "restricted"])
@php
        $img_id = $name;
        $info_url = ($name == "diamond") ? "/exchange-coins" : "/items/info?item=$name";
@endphp

<x-panel :$name :$restricted>
        <div class="flex gap-5 min-h-20">
                <x-item-img item="{{ $name }}" linkto="{{ $info_url }}"/>

                <div class="flex flex-col flex-1 items-center sm:items-start">
                        <h3 class="font-bold text-xl mb-2"><a href="/items/info?item={{ $name }}">{{ $item_name }}</a></h3>

                        <div class="text-md">
                                <p>Amount: {{ $count }}</p>
                                @if (!is_null($price))
                                <p>Price: {{ new \TPEx\TPEx\Coins($price)->pretty() }}</p>
                                @endif
                        </div>

                </div>

                <div class="text-lg font-bold flex flex-col justify-between">
                        @if (in_array($name, $restricted))
                        <a href="/items/buy?item={{ $name }}" class="self-center bg-red-100 px-2 py-1 rounded-md hover:bg-red-200 duration-300 cursor-pointer font-bold">Buy</a>
                        <a href="/items/sell?item={{ $name }}" class="self-center bg-red-100 px-2 py-1 rounded-md hover:bg-red-200 duration-300 cursor-pointer font-bold">Sell</a>
                        @else
                        <a href="/items/buy?item={{ $name }}" class="self-center bg-neutral-700 text-white px-2 py-1 rounded-md hover:bg-neutral-500 duration-300 cursor-pointer font-bold">Buy</a>
                        <a href="/items/sell?item={{ $name }}" class="self-center bg-neutral-700 text-white px-2 py-1 rounded-md hover:bg-neutral-500 duration-300 cursor-pointer font-bold">Sell</a>
                        @endif
                </div>
        </div>
</x-panel>
