<x-layout>
    <h3 class="text-center text-4xl">Register</h3>
    <form method="POST" action="/register" class="flex flex-col w-md m-auto mt-10 gap-5">
        @csrf
        <div class="flex flex-col gap-2">
            <label for="username" class="text-xl">Username</label>
            <input name="username" id="username" class="rounded-lg border border-gray-400 px-3 py-1" required/>
            <x-form-error name="username" />
        </div>

        <div class="flex flex-col gap-2">
            <label for="password" class="text-xl">Password</label>
            <input name="password" id="password" class="rounded-lg border border-gray-400 px-3 py-1" type="password" required/>
            <x-form-error name="password" />
        </div>

        <div class="flex flex-col gap-2">
            <label for="password_confirmation" class="text-xl">Confirm Password</label>
            <input name="password_confirmation" id="password_confirmation" class="rounded-lg border border-gray-400 px-3 py-1" type="password" required/>
            <x-form-error name="password_confirmation" />
        </div>

        <div class="flex flex-col gap-2">
            <label for="psk" class="text-xl">In-game TPEx sign password</label>
            <input name="psk" id="psk" class="rounded-lg border border-gray-400 px-3 py-1" type="text" required/>
            <x-form-error name="psk" />
        </div>

        <div>
            Already have an account? <a href="/login" class="font-bold hover:underline">Log in.</a>
        </div>

        <div class="flex justify-center gap-5 mt-3">
            <button type="submit" class="px-2 py-1 text-lg bg-neutral-700 text-white rounded-md hover:bg-neutral-500 duration-300 cursor-pointer font-bold">Register Account</button>
        </div>


    </form>

</x-layout>
