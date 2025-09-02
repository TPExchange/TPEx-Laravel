@props(["item_name"=>"Item Name", "count"=>"0", "name"=>"minecraft_cobblestone", "sys_id"=>"cobblestone", "price"=>null, "restricted"])
@php
        $img_id = "minecraft_" . $name;
@endphp

@if (in_array($name, $restricted))
<div class="w-100 bg-red-300 p-2 rounded-md">
@else
<div class="w-100 bg-neutral-300 p-2 rounded-md">
@endif
        <div class="flex gap-5">
                <x-item-img item="minecraft_{{ $name }}" linkto="/items/info?asset={{ $name }}"/>
                <div class="flex flex-col flex-1 items-center sm:items-start">
                        <h3 class="font-bold text-xl mb-2"><a href="/items/info?asset={{ $name }}">{{ $item_name }}</a></h3>

                        <div class="text-md">
                                <p>Amount: {{ $count }}</p>
                                @if (!is_null($price))
                                <p>Price: {{ $price }}</p>
                                @endif
                        </div>


                </div>

                <div class="text-lg font-bold flex flex-col justify-between">
                        <a href="/items/{{ $name }}/buy" class="self-center justify-self-end bg-neutral-200 px-2 py-1 rounded-full hover:bg-neutral-100 duration-300 cursor-pointer font-bold">Buy</a>
                        <a href="/items/{{ $name }}/sell" class="self-center justify-self-end bg-neutral-200 px-2 py-1 rounded-full hover:bg-neutral-100 duration-300 cursor-pointer font-bold">Sell</a>
                </div>
        </div>
</div>
