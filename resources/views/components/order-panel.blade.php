@props(["item_name"=>"Item Name", "count"=>"0", "name"=>"cobblestone", "sys_id"=>"cobblestone", "price"=>"N/A", "id"=>"-1", "restricted"])
@php
        $img_id = $name;
        $info_url = ($name == "diamond") ? "/exchange-coins" : "/items/info?item=$name";
@endphp
<x-panel class="flex items-center gap-5 flex-col sm:flex-row w-fit" :$name :$restricted :$info_url>
        <div class="flex gap-5 justify-between">
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
                        <form action="/orders/cancel/{{ $id }}" method="POST" class="my-auto">
                                @csrf
                                <button type="submit" href="/orders/cancel/{{ $id }}" class="self-center bg-neutral-700 text-white px-2 py-1 rounded-md hover:bg-neutral-500 duration-300 cursor-pointer font-bold">Cancel</button>
                        </form>
                </div>
        </div>
</x-panel>




