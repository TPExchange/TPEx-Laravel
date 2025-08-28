<x-layout>
    <h3 class="text-center text-4xl mb-3">
        {{ isset($item) ? "Buy " . ucwords(str_replace("_", " ", $item)) : "Buy Items" }}
    </h3>
    <h4 class="text-center mb-10">This will place a buy order. The items will be automatically bought when available at the specified price.</h4>


    <section class="mt-5">
        <form method="POST" action="" class="flex flex-col rounded-lg w-2xl m-auto py-3 px-10 gap-5 text-lg">
            @csrf

            <h2 class="text-2xl px-3 py-2 bg-neutral-200 rounded-sm">Place a buy order</h2>

            <div class="flex gap-5 justify-between">
                <label class="px-3">Item</label>
                <input list="item-list" name="item" class="px-1 border border-neutral-200 w-sm rounded-sm" value='{{ isset($item) ? $item : "" }}' />
                <datalist id="item-list">
                    @foreach ($items as $item)
                        <option value="{{ $item }}">{{ ucwords(str_replace("_", " ", $item)) }}</option>
                    @endforeach
                </datalist>
            </div>

            <div class="flex gap-5 justify-between">
                <label for="quantity" class="px-3">Amount</label>
                <input name="quantity" id="quantity" type="number" class="px-1 border border-neutral-200 w-sm rounded-sm"/>
            </div>

            <div class="flex gap-5 justify-between">
                <label for="price" class="px-3">Price per item (TPEx coins)</label>
                <input name="price" id="price" type="number" class="px-1 border border-neutral-200 w-sm rounded-sm flex-shrink-0"/>
            </div>

            <div class="flex justify-center gap-5 mt-2">
                <button id="submit" name="submit" type="submit" class="bg-green-300 hover:bg-green-400 duration-300 rounded-full px-3 py-1 cursor-pointer">Place Order</button>
            </div>

        </form>


    </section>
    

    {{-- <section class="mt-6">
        <h3 class="text-center text-xl font-bold">Existing Buy Orders</h3>
        <div class="grid lg:grid-cols-3 mt-5">
            @foreach ($orders as $order)
                <x-panel class="text-center w-60 h-full m-auto flex flex-col content-start">
                    <h3 class="text-lg font-bold">{{ $order["player"] }}</h3>
                    <h3 class="text-lg">Selling {{ $order["amount_remaining"] }} {{ $name }}(s)</h3>
                    <h3 class="text-lg">At {{ $order["price"] }} per item</h3>
                </x-panel>
            @endforeach
        </div>
    </section> --}}
</x-layout>