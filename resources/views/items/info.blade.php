<x-layout>
    <h3 class="text-center text-4xl mb-10">{{ucwords(str_replace("_", " ", $item))}} Information</h3>

    <div class="flex gap-5 w-fit m-auto">
        <a href="/items/buy?item={{ $item }}" class="flex m-auto text-center w-fit text-xl bg-neutral-700 text-white px-2 py-1 rounded-md hover:bg-neutral-500 duration-300 cursor-pointer font-bold">Buy {{ucwords(str_replace("_", " ", $item))}}</a>
        <a href="/items/sell?item={{ $item }}" class="flex m-auto text-center w-fit text-xl bg-neutral-300 text-neutral-950 px-2 py-1 rounded-md hover:bg-neutral-400 duration-300 cursor-pointer font-bold">Sell {{ucwords(str_replace("_", " ", $item))}}</a>
    </div>

    <x-item-history :$history :$item />
    <x-item-info :$buy :$sell :$item />
</x-layout>
