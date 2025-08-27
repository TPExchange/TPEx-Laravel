<x-layout>
    <x-page-title>Manual Password Reset</x-page-title>

    <form action="" method="POST" class="flex m-auto flex-col bg-neutral-200 rounded-lg w-lg p-5 text-center gap-5 text-lg items-center">
        @csrf
        @php
            $users = \App\Models\User::all();
        @endphp
        <select name="user" class="bg-white border border-neutral-400 rounded-lg px-3">
            <option value="">Select User to Reset</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->username }}</option>
            @endforeach

        </select>

        <input type="hidden" name="new_password" value="{{ str()->random(); }}"/>

        <button type="submit" class="cursor-pointer bg-red-300 hover:bg-red-500 w-fit px-3 py-1 rounded-full duration-300" onclick="return confirm('Are you sure you want to do this?')">Reset Password</button>
    </form>
</x-layout>