<x-layout>
    <h3 class="text-center text-4xl mb-10">Sell {{ $name }}</h3>


    <section class="mt-5">
        <form method="POST" action="/" class="flex flex-col bg-gray-200 rounded-lg w-lg m-auto py-3 px-10">
            @csrf

            <h3 class="text-center text-xl">Place A Sell Order</h3>

            <label for="quantity" class="mt-2">Amount</label>
            <input name="quantity" id="quantity" type="number" class="bg-white rounded-lg px-3 py-1 border border-gray-400"/>

            <label for="price" class="mt-2">Price</label>
            <input name="price" id="price" type="number" class="bg-white rounded-lg px-3 py-1 border border-gray-400"/>

            <fieldset>
                <label>Per Item</label>
                <input type="radio" name="price_style" value="per" checked/>

                <label>Total</label>
                <input type="radio" name="price_style" value="total"/>
            </fieldset>

            <div class="flex justify-center gap-5">
                <button id="clear" name="clear" type="reset" class="bg-blue-300 rounded-lg px-3 py-1 cursor-pointer">Clear</button>
                <button id="submitt" name="submit" type="submit" class="bg-green-300 rounded-lg px-3 py-1 cursor-pointer">Place Order</button>
            </div>

        </form>


    </section>
    

    <section class="mt-6">
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
    </section>
</x-layout>