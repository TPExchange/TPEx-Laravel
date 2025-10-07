<x-layout>
    <x-page-title>Welcome to Admin Control Panel!</x-page-title>

    <h3 class="text-center text-lg">Perform site admin actions from here</h3>

    <section class="mt-10">
        <div class="grid lg:grid-cols-3 gap-5 h-60">
            <x-dashboard-tile class="bg-red-300" href="/admin/transactions" icon="right-left">Transactions</x-dashboard-tile>
            <x-dashboard-tile class="bg-blue-300" href="/admin/manage-users" icon="user">Reset User Password</x-dashboard-tile>
            <x-dashboard-tile class="bg-green-300" href="/admin/deposits-withdrawals" icon="inbox">Deposits/Withdrawals</x-dashboard-tile>
        </div>
    </section>
</x-layout>