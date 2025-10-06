<x-layout>
    <x-page-title>Convert coins</x-page-title>

    <form method="post" action="" class="m-auto w-2xl bg-gray-100 rounded-md px-3 py-2 text-lg">
        @csrf
        <h2 class="underline text-xl">Convert between coins and diamonds:</h2>
        <h4 class="text-neutral-600 text-sm" id="rate">Diamonds->Coins fee: {{ $buyRate }}%</h4>

        @if ($errors->any())
            <div class="bg-red-300 px-3 py-1 rounded-sm flex flex-col">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (isset($success))
            <div class="bg-green-300 px-3 py-1 rounded-sm flex flex-col">
                <div>Currency successfully converted!</div>
            </div>
        @endif

        <script>
            buyRate = {{ $buyRate }};
            sellRate = {{ $sellRate }};
            baseRate = 1000;

            function swapConversion() {
                direction = $("#direction").val();
                if (direction == "diamondsToCoins") {
                    $("#direction").val("coinsToDiamonds");
                    $("#from").text("Coins");
                    $("#to").text("Diamonds");
                    $("#rate").text(`Coins->Diamonds fee: ${sellRate}%`);
                    $('#coins').val(calculateCoins());

                } else {
                    $("#direction").val("diamondsToCoins");
                    $("#from").text("Diamonds");
                    $("#to").text("Coins");
                    $("#rate").text(`Diamonds->Coins fee: ${buyRate}%`);
                    $('#coins').val(calculateCoins());
                }
                updateResult();
            }

            // Update the text summarising the transaction to the user
            function updateResult() {
                input = $("#quantity").val();
                direction = $("#direction").val();
                diamonds = Math.floor($("#diamonds").val());
                if (direction == "diamondsToCoins") {
                    // Converting diamonds into coins - use buying fee
                    mult = (1 - buyRate/100); // Find rate as a multiplier from percentage
                    rate = baseRate * mult; // Find coins:diamonds ratio
                } else {
                    // Converting coins into diamonds - use selling fee
                    mult = (1 + sellRate/100); // Find rate as a multiplier from percentage
                    rate = baseRate * mult; // Find coins:diamonds ratio
                }

                rate = baseRate * mult; // Find coins:diamonds ratio
                coins = diamonds * rate; // Find the number of diamonds



                if (direction == "diamondsToCoins") {
                    result = "Convert " + diamonds + " diamonds into " + coins + " coins";
                    $("#result").text(result);
                } else {
                    result = "Convert " + coins + " coins into " + diamonds + " diamonds";
                    $("#result").text(result);
                }
            }

            // Find the number if diamonds based off the number of coins
            function calculateDiamonds () {
                direction = $("#direction").val(); // Find the direction of trade to apply the appropriate fees
                coins = $("#coins").val(); // Find the number of coins


                if (direction == "diamondsToCoins") {
                    // Converting diamonds into coins - use buying fee
                    mult = (1 - buyRate/100); // Find rate as a multiplier from percentage
                } else {
                    // Converting coins into diamonds - use selling fee
                    mult = (1 + sellRate/100); // Find rate as a multiplier from percentage
                }

                rate = baseRate * mult; // Find coins:diamonds ratio
                diamonds = coins / rate; // Find the number of diamonds

                return diamonds; // Return result
            }

            function calculateCoins () {
                direction = $("#direction").val(); // Find the direction of trade to apply the appropriate fees
                diamonds = $("#diamonds").val(); // Find the number of diamonds

                if (direction == "diamondsToCoins") {
                    // Converting diamonds into coins - use buying fee
                    mult = (1 - buyRate/100); // Find rate as a multiplier from percentage
                    rate = baseRate * mult; // Find coins:diamonds ratio
                } else {
                    // Converting coins into diamonds - use selling fee
                    mult = (1 + sellRate/100); // Find rate as a multiplier from percentage
                    rate = baseRate * mult; // Find coins:diamonds ratio
                }

                rate = baseRate * mult; // Find coins:diamonds ratio
                coins = diamonds * rate; // Find the number of diamonds

                return coins; // Return result
            }
        </script>
        <div class="flex flex-col mt-5 gap-2" id="items-list">
            <div class="flex flex-col bg-neutral-100 gap-5">
                <div class="flex bg-neutral-50 border border-neutral-200 h-7 mb-5">
                    <span class="flex-1 flex h-7 self-center">
                        <span class="text-neutral-500 border-r border-neutral-200 px-2">From</span>
                        <span class="px-2" id="from">Diamonds</span>
                    </span>
                    <div class="text-center cursor-pointer bg-white border border-neutral-200 w-10 h-10 content-center self-center text-neutral-600 hover:text-black hover:bg-neutral-200 duration-300 rounded-full" onclick="swapConversion();"><i class="fa fa-arrow-right-arrow-left"></i></div>
                    <span class="flex-1 flex h-7 self-center">
                        <span class="text-neutral-500 border-r border-neutral-200 px-2">To</span>
                        <span class="px-2" id="to">Coins</span>
                    </span>
                    <input type="hidden" name="direction" value="diamondsToCoins" id="direction" required />
                </div>

                <div class="flex text-center m-auto bg-neutral-50 border border-neutral-200 rounded-md w-60 py-1">
                    <input id="diamonds" name="diamonds" type="number" class="bg-neutral-50 border-r border-neutral-200 rounded-l-md w-30 px-2" value=0 oninput="$('#coins').val(calculateCoins()); updateResult();" required/>
                    <label for="diamonds" class="px-2 text-right">Diamonds</label>
                </div>

                <div class="flex text-center m-auto bg-neutral-50 border border-neutral-200 rounded-md w-60 py-1">
                    <input id="coins" name="coins" type="number" class="bg-neutral-50 border-r border-neutral-200 rounded-l-md w-30 px-2" value=0 oninput="$('#diamonds').val(calculateDiamonds()); updateResult();" required/>
                    <label for="coins" class="px-2 text-right">Coins</label>
                </div>

                <div class="m-auto">
                    <span class="font-bold" id="result"></span>
                </div>
            </div>
        </div>

        <button class="block mt-5 m-auto w-fit bg-neutral-700 text-white px-2 py-1 rounded-md hover:bg-neutral-500 duration-300 cursor-pointer font-bold" onclick="return confirm('Are you sure you want to do this?')">Convert Currency</button>
    </form>
    <script>
        // Check to see if this is supposed to be converting coins into diamonds ("buying" diamonds)
        if ((new URLSearchParams(window.location.search)).get("mode") === "buy") {
            swapConversion();
        }
    </script>
</x-layout>
