<x-layout>
    @php
        $remote = new TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $transactions = $remote->raw_state();
        $transactions = explode("\n", $transactions);
        array_pop($transactions);
        if (request("order") != "oldest") {
            $transactions = array_reverse($transactions);
        }
    @endphp

    <x-page-title>Transaction Log</x-page-title>

    <section class="mt-20">
        <div class="flex justify-between mb-2">
            <h3 class="text-2xl">Full Transaction Log</h3>
            <form action="" method="GET" class="font-lg gap-5 flex items-center">
                <select name="filter" onchange="this.form.submit()" class="border border-gray-400 rounded-lg">
                    <option value="">Select Filter</option>
                    @php
                        $typesArray = ["Deposit","CancelOrder", "RequestWithdrawal", "CompleteWithdrawal", "Deleted", "UpdateBankers", "UpdateBankPrices", "UpdateRestricted", "SellOrder", "BuyOrder", "BuyCoins", "SellCoins"];
                        asort($typesArray);
                    @endphp
                    @foreach ($typesArray as $type)
                        <option value="{{ $type }}"
                        @if (request("filter") == $type)
                            selected
                        @endif
                        >{{ $type }}</option>
                    @endforeach
                </select>
                @if (request("order") == "oldest")
                    <button type="submit" name="order" value="newest" class="cursor-pointer border border-gray-400 rounded-lg px-3">Order <i class="fa fa-arrow-up-short-wide"></i></a>
                @else
                    <button type="submit" name="order" value="oldest" class="cursor-pointer border border-gray-400 rounded-lg px-3">Order <i class="fa fa-arrow-down-short-wide"></i></a>
                @endif
            </form>
        </div>



        <div class="flex flex-col bg-neutral-100 px-5">

            @foreach ($transactions as $object)
                @php
                    $object = json_decode($object);
                    $type = array_keys(get_object_vars($object->action))[0];
                @endphp
                @if ((!request("filter")) || (request("filter") == $type))
                    @php
                        $details = ($object->action->$type);
                    @endphp

                    <x-link-panel class="flex gap-5 font-mono text-lg" href="/admin/transactions/{{ $object->id }}">
                            <div class="bg-neutral-200 px-2 py-1 rounded-md">ID: {{ $object->id }}</div>
                            <div class="bg-neutral-200 px-2 py-1 rounded-md">TYPE: {{ $type }}</div>
                            @foreach (array_keys(get_object_vars($details)) as $detail)
                                @php
                                    if (is_array($details->$detail)) {
                                        $contents = implode( ", ", $details->$detail);
                                    } elseif (is_string($details->$detail) || is_int($details->$detail)) {
                                        $contents = $details->$detail;
                                    } else {
                                        $contents = "";
                                    }
                                @endphp
                                @if ($contents)
                                    <div class="bg-neutral-200 px-2 py-1 rounded-md">
                                        {{ strtoupper($detail) . ": " . $contents }}
                                    </div>
                                @endif

                            @endforeach
                        </a>
                    </x-panel>
                @endif
            @endforeach
        </div>
    </section>
</x-layout>
