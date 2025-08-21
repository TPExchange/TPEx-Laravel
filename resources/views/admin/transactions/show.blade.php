<x-layout>
    @php
        $path = database_path() . "/trades.list"; // Path to log
        $log = file_get_contents($path); // Load log JSON
        $transactions = explode("\n", $log); // Convert to array on line breaks
        $transaction = $transactions[$id - 1]; // -1 accounts for zero indexing ($id passed in via routes controller)
        $object = json_decode($transaction);
        $type =  array_keys(get_object_vars($object->action))[0];
        $details = get_object_vars($object->action->$type);


    @endphp
    <x-page-title>Transaction ID {{ $id }}</x-page-title>

    <div class="text-xl font-mono flex flex-col gap-5 bg-neutral-100 px-5 pt-2 pb-10">
        <div class="px-2 py-1 w-fit text-2xl font-bold">TRANSACTION DETAILS</div>
        <div class="border-b border-neutral-300 px-2 py-1 w-fit">TRANSACTION ID: {{ $id }}</div>
        <div class="border-b border-neutral-300 px-2 py-1 w-fit">TRANSACTION TYPE: {{ $type }}</div>
        <div class="border-b border-neutral-300 px-2 py-1 w-fit">TRANSACTION TIME: {{ date("D, d M Y H:i:s",strtotime($object->time)) }}</div>
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
                <div class="border-b border-neutral-300 px-2 py-1 w-fit">
                    {{ strtoupper($detail) . ": " . $contents }}
                </div>
            @endif
            
        @endforeach

        <div class="border-b border-neutral-300 px-2 py-1 w-fit">RAW TRANSACTION JSON: {{ $transaction }}</div>
    </div>


</x-layout>