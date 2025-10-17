<x-layout>
    <x-page-title>Withdrawal {{$id}}</x-page-title>

    <section class="mt-10 mb-20 w-xl m-auto bg-white border border-neutral-800 px-5 py-3 gap-5 rounded-md flex flex-col text-lg">
        <div>
            <h2 class="font-bold underline">Player</h2>
            <p>{{ $withdrawal["player"] }}</p>
        </div>

        <div>
            <h2 class="font-bold underline">Items</h2>
            <p>
                @foreach ($withdrawal["assets"] as $asset=>$count)
                    <button class="cursor-pointer hover:bg-neutral-200 duration-300 rounded-sm" onclick="calculateItem({{ $assetInfo[$asset]->{'minecraft:max_stack_size'} }}, {{ $count }})">{{ $count . " " . $asset}}</button>
                    <br>
                @endforeach
            </p>
        </div>

        <form method="post" action="/admin/complete-withdrawal" class="m-auto">
            @csrf
            <button name="withdrawal_id" value="{{ $id }}" class="m-auto bg-green-300 hover:bg-green-400 transition-bg duration-300 rounded-full w-15 cursor-pointer text-2xl"><i class="fa fa-check"></i></button>
        </form>
    </section>

    <x-withdrawal-calculator />
</x-layout>