<x-layout>
    <x-page-title>Withdraw Items</x-page-title>

    <form method="post" action="" class="m-auto w-2xl bg-gray-100 rounded-md px-3 py-2 text-lg">
        @csrf
        <h2 class="underline text-xl">Items to withdraw:</h2>
        <h4 class="text-neutral-600 text-sm">Item names should be written in lowercase</h4>

        @if ($errors->any())
            <div class="bg-red-300 px-3 py-1 rounded-sm flex flex-col">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (isset($success))
            <div class="bg-green-300 px-3 py-1 rounded-sm flex flex-col">
                <div>Withdrawal request submitted!</div>
            </div>
        @endif

        <datalist id="items-list-data">
            @foreach ($items as $item)
                <option value="{{ $item }}">{{ ucwords(str_replace("_", " ", $item)) }}</option>
            @endforeach
        </datalist>

        <script>
            let inputField = `
                <div class="flex flex-row border border-neutral-200 bg-neutral-200">
                    <input class="flex-1 bg-neutral-50 duration-300 border-r border-neutral-200 px-2" placeholder="Item Name" list="items-list-data" name="items[]"/>
                    <input class="flex-1 bg-neutral-50 duration-300 border-r border-neutral-200 px-2" placeholder="Count" name="counts[]"/>
                    <div class="text-center cursor-pointer bg-neutral-200 w-7 text-neutral-600 hover:text-black duration-300" onclick="this.parentElement.remove();"><i class="fa fa-xmark"></i></div>
                </div>`;
        </script>

        <div class="flex flex-col mt-5 gap-2" id="items-list">
            <div class="flex flex-row">
                <div class="flex-1 duration-300 border-r border-transparent px-2">Item Name</div>
                <div class="flex-1 duration-300 border-r border-transparent px-2">Count</div>
                <div class="text-center cursor-pointer w-7 text-neutral-600 hover:text-black duration-300" onclick="$('#items-list').append(inputField);
                "><i class="fa fa-plus"></i></div>
            </div>
            <div class="flex flex-row border border-neutral-200 bg-neutral-200">
                <input class="flex-1 bg-neutral-50 duration-300 border-r border-neutral-200 px-2" placeholder="Item Name" list="items-list-data" name="items[]"/>
                <input class="flex-1 bg-neutral-50 duration-300 border-r border-neutral-200 px-2" placeholder="Count" name="counts[]"/>
                <div class="text-center cursor-pointer bg-neutral-200 w-7 text-neutral-600 hover:text-black duration-300" onclick="this.parentElement.remove();"><i class="fa fa-xmark"></i></div>
            </div>
        </div>

        <button class="block mt-5 m-auto w-fit bg-green-300 hover:bg-green-400 transition-bg duration-300 px-3 py-1 rounded-full cursor-pointer" onclick="return confirm('Are you sure you want to do this?')">Withdraw Items</button>
    </form>
</x-layout>