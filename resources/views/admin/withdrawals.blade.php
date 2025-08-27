<x-layout>
    <x-page-title>Deposits/Withdrawals</x-page-title>

    <h3 class="text-center text-lg">Mark withdrawals as complete</h3>

    <section class="mt-10 w-xl m-auto bg-neutral-100 px-5 py-3 gap-5 rounded-md flex flex-col">
        <div class="border-b border-neutral-200 text-lg flex justify-around font-bold">
            <span class="w-30">ID</span>
            <span>Username</span>
        </div>
        @foreach ($withdrawals as $id=>$item)
            @php
                $player = $item["player"];
            @endphp
            <a href="/admin/withdrawals/{{ $id }}" class="border-b border-neutral-200 hover:bg-neutral-200 transition-bg duration-300 text-lg flex justify-around rounded-t-md">
                @csrf
                <span class="w-30">{{ $id }}</span>
                <span>{{ $player }}</span>
            </a>    
        @endforeach

    </section>
</x-layout>