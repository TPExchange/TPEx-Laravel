<x-layout>
    <x-page-title>Deposits</x-page-title>
    <form method="POST" action="/admin/deposits" class="flex flex-col rounded-lg w-2xl m-auto py-3 px-10 gap-5 text-lg" autocomplete="off">
        <h2 class="text-2xl px-3 py-2 bg-neutral-200 rounded-sm">Make new deposit</h2>
        @csrf

        @if ($errors->any())
            <div class="bg-red-300 px-3 py-1 rounded-sm flex flex-col">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (isset($success))
            <div class="bg-green-300 px-3 py-1 rounded-sm flex flex-col">
                <div>Item(s) deposited successfully!</div>
            </div>
        @endif

        <div class="flex gap-5 justify-between">
            <label class="px-3">Player Name</label>
            <input list="players-list" name="player" class="px-1 border border-neutral-400 w-sm rounded-sm" required />
            <datalist id="players-list" autocomplete="off">
                @foreach ($players as $player)
                    <option value="{{ $player->username }}"></option>
                @endforeach
            </datalist>
        </div>

        <div class="flex gap-5 justify-between">
            <label class="px-3">Item</label>
            <x-item-selector :$items name="item" required=true />
        </div>

        <div class="flex gap-5 justify-between">
            <label class="px-3">Quantity</label>
            <input name="quantity" type="number" class="px-1 border border-neutral-400 w-sm rounded-sm" required />
        </div>

        <div class="flex gap-5 justify-between">
            <label class="px-3">Confirm Quantity</label>
            <input name="quantityConfirm" type="number" class="px-1 border border-neutral-400 w-sm rounded-sm" required />
        </div>

        <button type="submit" class="px-2 py-1 text-lg bg-neutral-700 text-white rounded-md hover:bg-neutral-500 duration-300 cursor-pointer font-bold w-fit m-auto">Deposit Items</button>
    </form>

</x-layout>
