<div class="w-xl m-auto mt-10 text-xl">
    <h2 class="text-2xl px-3 py-2 bg-neutral-200 rounded-sm">Withdrawal Calculator</h2>

    <div class="mt-10 mx-auto w-fit flex gap-5 items-center">
        <label for="item-count-input">Items</label>
        <input id="item-count-input" type="number" class="bg-white border border-neutral-400 rounded-md px-2 w-40" autocomplete="off"/>


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



    <span class="text-center m-auto w-fit block underline">Is equal to <span id="output-shulkers">0</span> shulkers, <span id="output-stacks">0</span> stacks, and <span id="output-items">0</span> items.







    <script>
        $("input").on("input", updateCalculator);

        function updateCalculator() {
            let items;
            // Fetch number of items
            $("#item-count-input").val() == "" ? items = 0 : items = parseInt($("#item-count-input").val());
            let stackSize = $("input[name='stack-size']:checked").val();

            

            // Find number of shulkers
            let shulkers = 0;
            while (items > 27*stackSize) {
                shulkers += 1;
                items -= 27*stackSize;
            }

            // Find number of stacks
            let stacks = 0;
            while (items > stackSize) {
                stacks += 1;
                items -= stackSize;
            }

            // Output values
            $("#output-shulkers").text(shulkers);
            $("#output-stacks").text(stacks);
            $("#output-items").text(items);

        }

        function calculateItem(stackSize, quantity) {
            // Add item quantity
            $("#item-count-input").val(quantity);
            // Uncheck radio buttons
            $("input[type='radio']").attr("checked", false);
            // Check correct radio button
            $(`#${stackSize}`).attr("checked", true);
            // Run updateCalculator
            updateCalculator();
        }

    </script>
</div>