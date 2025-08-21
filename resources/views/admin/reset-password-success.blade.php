<x-layout>
    <x-page-title>Manual Password Reset</x-page-title>

    <div class="flex m-auto flex-col bg-gray-200 rounded-lg w-lg p-5 text-center gap-5 text-lg items-center">
        <h3 class="text-center text-xl">Password Reset!</h3>
        <h3>Password for <span class="font-bold">{{ $reset_user->username }}</span> changed to <span class="font-bold">{{ $new_password }}</span></h3>

    </div>
</x-layout>