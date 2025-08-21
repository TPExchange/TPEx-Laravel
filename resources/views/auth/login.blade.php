<x-layout>
    <h3 class="text-center text-4xl">Log In</h3>
    <form method="POST" action="/login" class="flex flex-col w-md m-auto mt-10 gap-5">
        @csrf
        <div class="flex flex-col gap-2">
            <label for="username" class="text-xl">Username</label>
            <input name="username" id="username" class="rounded-lg border border-gray-400 px-3 py-1" :value="old('username')" required/>
            
        </div>

            <div class="flex flex-col gap-2">
            <label for="password" class="text-xl">Password</label>
            <input name="password" id="password" class="rounded-lg border border-gray-400 px-3 py-1" type="password" required/>
            <x-form-error name="password" />
        </div>
        
        <div>
            No account? <a href="/register" class="font-bold hover:underline">Register here.</a>
        </div>

        <div class="flex justify-center gap-5 mt-3">
            <button type="reset" class="px-3 py-1 rounded-lg bg-blue-300 cursor-pointer text-lg hover:bg-blue-400 transition-bg duration-300">Clear</button>
            <button type="submit" class="px-3 py-1 rounded-lg bg-green-300 cursor-pointer text-lg hover:bg-green-400 transition-bg duration-300">Log In</button>
        </div>


    </form>

</x-layout>