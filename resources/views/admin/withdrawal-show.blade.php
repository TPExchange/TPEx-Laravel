<x-layout>
    <x-page-title>Deposits/Withdrawals</x-page-title>

    <h3 class="text-center text-lg">Mark withdrawals as complete</h3>

    <section class="mt-10 w-xl m-auto bg-neutral-100 px-5 py-3 gap-5 rounded-md flex flex-col text-lg">
        <div>
            <h2 class="font-bold">ID</h2>
            <p>{{ $id }}</p>
        </div>

        <div>
            <h2 class="font-bold">Player</h2>
            <p>{{ $withdrawal["player"] }}</p>
        </div>

        <div>
            <h2 class="font-bold">Items</h2>
            <p>
                @foreach ($withdrawal["assets"] as $asset=>$count)
                    {{ $count . " " . $asset}}
                    <br>
                @endforeach
            </p>
        </div>

        <form method="post" action="/admin/complete-withdrawal" class="m-auto">
            @csrf
            <button name="withdrawal_id" value="{{ $id }}" class="m-auto bg-green-300 hover:bg-green-400 transition-bg duration-300 rounded-full w-15 cursor-pointer text-2xl"><i class="fa fa-check"></i></button>
        </form>
    </section>
</x-layout>