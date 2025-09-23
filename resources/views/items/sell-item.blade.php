<x-layout>
    <h3 class="text-center text-4xl mb-3">Sell {{ $name }}</h3>
    <h4 class="text-center mb-10">This will place a sell order. Items might not be bought immediately.</h4>


    <section class="mt-5">
        <form method="POST" action="/items/sell" class="flex flex-col rounded-lg w-2xl m-auto py-3 px-10 gap-5 text-lg">
            @csrf

            @if ($errors->any())
                <div class="bg-red-300 px-3 py-1 rounded-sm flex flex-col">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="bg-red-300 px-3 py-1 rounded-sm flex flex-col hidden" id="restricted">
                <div>This item is <span class="font-bold">restricted.</span> There may be limitations on how and when it can be withdrawn or sold.</div>
            </div>


            <script>
                restricted = '{{ implode(",", $restricted) }}'.split(","); // Restricted array

                function checkRestricted() {
                    item = $("#item").val();
                    if (restricted.includes(item)) {
                        $("#restricted").removeClass("hidden");
                    } else {
                        $("#restricted").addClass("hidden");
                    }
                }

                function updateTotal() {
                    amount = $("#quantity").val();
                    price = $("#price").val();
                    total = amount * price;
                    $("#totalprice").text(total.toFixed(3).replace(/\.?0*$/,""));
                }
            </script>

            <h2 class="text-2xl px-3 py-2 bg-neutral-200 rounded-sm">Place a sell order</h2>

            <div class="flex gap-5 justify-between">
                <label for="item" class="px-3">Item</label>

                <x-item-selector :$item :$items />
            </div>

            <div class="flex gap-5 justify-between">
                <label for="quantity" class="px-3">Amount</label>
                <input name="quantity" id="quantity" type="number" class="px-1 border border-neutral-200 w-sm rounded-sm"  oninput="updateTotal();" required />
            </div>

            <div class="flex gap-5 justify-between">
                <label for="price" class="px-3">Price per item (TPEx coins)</label>
                <input name="price" id="price" type="number" step="0.001" class="px-1 border border-neutral-200 w-sm rounded-sm flex-shrink-0" oninput="updateTotal();" required />
            </div>

            <div class="flex gap-5 justify-between">
                <label for="price" class="px-3">Total profit (TPEx coins)</label>
                <span id="totalprice" type="number" class="px-1 border border-neutral-200 w-sm rounded-sm flex-shrink-0 content-center"></span>
            </div>

            <div class="flex justify-center gap-5 mt-2">
                <button id="submit" name="submit" type="submit" class="bg-green-300 hover:bg-green-400 duration-300 rounded-full px-3 py-1 cursor-pointer">Place Order</button>
            </div>

        </form>


    </section>

    <script>checkRestricted();</script>

</x-layout>
