@props(["item_name"=>"Item Name", "count"=>"0", "name"=>"cobblestone", "sys_id"=>"cobblestone", "price"=>"N/A", "id"=>"-1"])
@php
        $img_id = $name;
@endphp
<x-panel class="flex items-center gap-5 flex-col sm:flex-row w-fit">
        <div class="collapse sm:visible h-0 sm:h-auto">
                <img src="{{'/images/items/' . $img_id . '.png'}}" class="w-20" alt="" />
        </div>
        <div class="flex flex-col items-center sm:items-start">
                <h3 class="font-bold text-xl mb-2">{{ $item_name }}</h3>

                <div class="text-md">
                        <p>Amount: {{ $count }}</p>
                        <p>Price: {{ $price }}</p>
                </div>


        </div>

        <div class="mt-3 text-lg font-bold flex flex-col justify-center h-full">
            <form action="/orders/cancel/{{ $id }}" method="post">
                @csrf
                <button class="bg-red-300 px-3 py-1 rounded-lg hover:bg-red-400 cursor-pointer">Cancel</button>
            </form>
        </div>
</x-panel>
