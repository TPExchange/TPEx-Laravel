@props(["item_name"=>"Item Name", "count"=>"0", "name"=>"minecraft_cobblestone", "sys_id"=>"cobblestone", "price"=>"N/A"])
@php
        $img_id = "minecraft_" . $name;
@endphp
<x-panel class="flex items-center justify-between flex-col sm:flex-row">
        <div class="flex flex-col items-center sm:items-start">
                <h3 class="font-bold text-xl mb-2">{{ $item_name }}</h3>

                <div class="text-md">
                        <p>Amount: {{ $count }}</p>
                        <p>Price: {{ $price }}</p>
                </div>

                <div class="space-x-3 mt-3 text-lg font-bold">
                        <a href="/items/{{ $name }}/buy" class="bg-green-300 px-3 py-1 rounded-lg hover:bg-green-400">Buy</a>
                        <a href="/items/{{ $name }}/sell" class="bg-red-300 px-3 py-1 rounded-lg hover:bg-red-400">Sell</a>
                </div>
        </div>
        <div class="collapse sm:visible h-0 sm:h-auto">
                <img src="{{'/images/items/' . $img_id . '.png'}}" class="w-20" alt="" />
        </div>
</x-panel>