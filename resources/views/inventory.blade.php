<x-layout>
    <h3 class="text-center text-4xl mb-10">Your Inventory</h3>

    <x-search action="/inventory/search"></x-search>



    <section class="relative">
        <div class="absolute -top-10 flex items-center">
            <h3 class="text-xl px-3 py-1 rounded-lg">TPEx coins: <span class="font-bold">{{ $coins }}</span></h3>
            <a href="/exchange-coins" class="text-xl border border-transparent text-green-700 hover:text-green-900 rounded-full transition-all duration-300"><i class="fa fa-money-bill-transfer"></i></a>
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
            <div class="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-5 px-5">
                @foreach (array_keys($inventory) as $item)
                    <div class="bg-neutral-300 p-2 rounded-md">
                        <div class="flex gap-5">
                            <x-item-img item="minecraft_{{ $item }}"/>

                            <div class="flex flex-col justify-center flex-1">
                                <h3 class="font-bold text-xl">
                                    {{ ucwords(str_replace("_", " ", $item)) }}
                                </h3>
                                <p>Count: {{ $inventory[$item] }}</p>
                            </div>

                            <a href="/items/{{ $item }}/sell" class="self-center justify-self-end bg-neutral-200 px-2 py-1 rounded-full hover:bg-neutral-100 duration-300 cursor-pointer font-bold">Sell</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</x-layout>