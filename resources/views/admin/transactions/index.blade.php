<x-layout>
    @php
        $path = database_path() . "/trades.list";
        $log = file_get_contents($path);
        $transactions = explode("\n", $log);
        $latestid = (json_decode(end($transactions))->id);
        $newid = $latestid + 1;
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
                        $typesArray = ["Deposit","CancelOrder", "WithdrawalRequested", "WithdrawalCompleted", "Deleted", "UpdateBankers", "UpdateBankPrices", "UpdateRestricted", "SellOrder", "BuyOrder", "BuyCoins", "SellCoins"];
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

            @foreach ($transactions as $transaction)
                @php
                    $object = json_decode($transaction);
                    $type =  array_keys(get_object_vars($object->action))[0];
                    $details = get_object_vars($object->action->$type);
                @endphp
                @if ((!request("filter")) || (request("filter") == $type))
                    @php
                        $object = json_decode($transaction);
                        $type =  array_keys(get_object_vars($object->action))[0];
                        $details = get_object_vars($object->action->$type);
                    @endphp

                    <x-link-panel class="flex gap-5 font-mono text-lg" href="/admin/transactions/{{ $object->id }}">
                            <div class="bg-neutral-200 px-2 py-1 rounded-md">ID: {{ $object->id }}</div>
                            <div class="bg-neutral-200 px-2 py-1 rounded-md">TYPE: {{ $type }}</div>
                            @foreach (array_keys($details) as $detail)
                                @php
                                    if (is_array($details[$detail])) {
                                        $contents = implode( ", ", $details[$detail]);
                                    } elseif (is_string($details[$detail]) || is_int($details[$detail])) {
                                        $contents = $details[$detail];
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

                        {{-- <a href="#" class="ml-auto"><i class="fa fa-pencil text-gray-600 hover:text-black"></i></a> --}}
                        
                    </x-panel>
                @endif
            @endforeach
        </div>
    </section>
</x-layout>
