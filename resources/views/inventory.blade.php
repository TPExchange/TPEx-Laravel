<x-layout>
    <h3 class="text-center text-4xl mb-10">Your Inventory</h3>

    <x-search action="/inventory/search"></x-search>

    <section class="relative">
        <div class="absolute -top-10 flex items-center">
            <h3 class="text-xl px-3 py-1 rounded-lg">TPEx coins: <span class="font-bold">{{ new \TPEx\TPEx\Coins($coins)->pretty() }}</span></h3>
            <a href="/exchange-coins" class="text-xl border border-transparent text-green-700 hover:text-green-900 rounded-full transition-all duration-300"><i class="fa fa-money-bill-transfer"></i> Convert</a>
        </div>
        <a href="/withdraw" class="absolute -top-10 flex items-center text-xl py-1 right-0 bg-blue-400 hover:bg-blue-500 text-white transition-bg duration-300 px-3 rounded-full cursor-pointer">Withdraw Items</a>
        <div class="bg-neutral-100 rounded-lg pb-5">
            <x-section-header>
                @if (request("q"))
                    Results For: "{{ htmlspecialchars(request("q")) }}"
                @else
                    Your Items
                @endif
            </x-section-header>
            <div class="flex gap-3 mb-2 p-5">
                @foreach (array_keys($inventory) as $item)
                    <x-item-panel item_name="{{ ucwords(str_replace('_', ' ', $item)) }}" name="{{ $item }}" count="{{ $inventory[$item] }}" :$restricted/>
                @endforeach
            </div>
        </div>
    </section>

</x-layout>
