<x-layout>
    <x-page-title>Deposits</x-page-title>

    <form method="POST" action="/admin/deposits" class="flex flex-col rounded-lg w-2xl m-auto py-3 px-10 gap-5 text-lg">
        <h2 class="text-2xl px-3 py-2 bg-neutral-200 rounded-sm">Make new deposit</h2>
        @csrf

        @if ($errors->any())
            <div class="bg-red-300 px-3 py-1 rounded-sm flex flex-col">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="flex gap-5 justify-between">
            <label class="px-3">Player Name</label>
            <input list="players-list" name="player" class="px-1 border border-neutral-200 w-sm rounded-sm"/>
            <datalist id="players-list">
                @foreach ($players as $player)
                    <option value="{{ $player->username }}"></option>
                @endforeach
            </datalist>
        </div>

        <div class="flex gap-5 justify-between">
            <label class="px-3">Item</label>
            <input list="item-list" name="item" class="px-1 border border-neutral-200 w-sm rounded-sm"/>
            <datalist id="item-list">
                @foreach ($items as $item)
                    <option value="{{ $item }}"></option>
                @endforeach
            </datalist>
        </div>

        <div class="flex gap-5 justify-between">
            <label class="px-3">Quantity</label>
            <input name="quantity" type="number" class="px-1 border border-neutral-200 w-sm rounded-sm"/>
        </div>

        <div class="flex gap-5 justify-between">
            <label class="px-3">Confirm Quantity</label>
            <input name="quantityConfirm" type="number" class="px-1 border border-neutral-200 w-sm rounded-sm"/>
        </div>

        <button type="submit" class="px-3 py-2 bg-blue-300 w-fit m-auto rounded-full hover:bg-blue-200 transition-bg duration-300 cursor-pointer">Deposit Items</button>
    </form>

</x-layout>