<div class="w-xl m-auto mt-10 text-xl">
    <h2 class="text-2xl px-3 py-2 bg-neutral-200 rounded-sm">Deposit Calculator</h2>

    <div class="mt-10 mx-auto w-fit flex flex-col gap-5 items-center">
        <span class="w-50 flex block m-auto justify-end gap-5">
            <label for="shulkers-input" class="text-center flex-1">Shulkers</label>
            <input id="shulkers-input" type="number" class="bg-white border border-neutral-400 rounded-md px-2 w-20" autocomplete="off"/>
        </span>
        <span class="w-50 flex block m-auto justify-end gap-5">
            <label for="stacks-input" class="text-center flex-1">Stacks</label>
            <input id="stacks-input" type="number" class="bg-white border border-neutral-400 rounded-md px-2 w-20" autocomplete="off"/>
        </span>
        <span class="w-50 flex block m-auto justify-end gap-5">
            <label for="item-count-input" class="text-center flex-1">Items</label>
            <input id="item-count-input" type="number" class="bg-white border border-neutral-400 rounded-md px-2 w-20" autocomplete="off"/>
        </span>


        <div class="mx-auto my-5 w-fit text-lg">
            <h4 class="text-center">Stack Size</h4>
            <label for="64">64</label>
            <input type="radio" name="stack-size" value="64" id="64" checked/>
            <label for="16">16</label>
            <input type="radio" name="stack-size" value="16" id="16"/>
            <label for="1">1</label>
            <input type="radio" name="stack-size" value="1" id="1"/>
        </div>
    </div>



    <span class="text-center m-auto w-fit block underline">Is equal to <span id="output-items">0</span> items.







    <script>
        $("input").on("input", updateCalculator);

        function updateCalculator() {
            let shulkers;
            let stacks;
            let items;
            // Fetch number of items
            $("#shulkers-input").val() == "" ? shulkers = 0 : shulkers = parseInt($("#shulkers-input").val());
            $("#stacks-input").val() == "" ? stacks = 0 : stacks = parseInt($("#stacks-input").val());
            $("#item-count-input").val() == "" ? items = 0 : items = parseInt($("#item-count-input").val());

            let stackSize = $("input[name='stack-size']:checked").val();

            
            items = shulkers * 27 * stackSize + stacks * stackSize + items;

            // Output value
            $("#output-items").text(items);

        }

    </script>
</div>