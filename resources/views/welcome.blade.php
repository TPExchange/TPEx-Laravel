<x-layout>
    <x-page-title class="text-center text-4xl mb-5">
        @guest
        Welcome to TPEx!
        @endguest
        @auth
            Welcome, {{ Auth::user()->username }}!
        @endauth

    </x-page-title>
    <h3 class="text-center text-lg">Browse available items, request to withdraw items, or place buy/sell orders</h3>

    <section class="mt-10">
        
        <div class="grid lg:grid-cols-3 gap-5 h-60">
            <x-dashboard-tile colour="red" href="/items" icon="right-left">
                Trade Items
            </x-dashboard-tile>
            

            <x-dashboard-tile colour="blue" href="/inventory" icon="list">
                View Inventory
            </x-dashboard-tile>

            <x-dashboard-tile colour="green" href="/account" icon="clipboard">
                Manage Orders
            </x-dashboard-tile>

        </div>
        
    </section>
</x-layout>