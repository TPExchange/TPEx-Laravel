<x-layout>
    <x-page-title>Welcome to Admin Control Panel!</x-page-title>

    <h3 class="text-center text-lg">Perform site admin actions from here</h3>

    <section class="mt-10">
        <div class="grid lg:grid-cols-3 gap-5 h-60">
            <x-dashboard-tile colour="red" href="/admin/transactions" icon="right-left">Transactions</x-dashboard-tile>
            <x-dashboard-tile colour="blue" href="/admin/manage-users" icon="user">Reset User Password</x-dashboard-tile>
            <x-dashboard-tile colour="green" href="/admin/deposits-withdrawals" icon="inbox">Deposits/Withdrawals</x-dashboard-tile>
        </div>
    </section>
</x-layout>