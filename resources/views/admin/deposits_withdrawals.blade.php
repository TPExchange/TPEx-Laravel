<x-layout>
    <x-page-title>Deposits/Withdrawals</x-page-title>

    <h3 class="text-center text-lg">Manage deposits and withdrawals here</h3>

    <section class="mt-10">
        <div class="grid lg:grid-cols-2 gap-5 h-60">
            <x-dashboard-tile class="bg-red-300" href="/admin/deposits" icon="arrow-down">Deposits</x-dashboard-tile>
            <x-dashboard-tile class="bg-blue-300" href="/admin/withdrawals" icon="arrow-up">Withdrawals</x-dashboard-tile>
        </div>
    </section>
</x-layout>