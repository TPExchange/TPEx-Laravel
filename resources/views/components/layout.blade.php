<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPEx</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(["resources/js/app.js", "resources/css/app.css"])
    
</head>

<body class="font-hanken-grotesk">

    <!-- Wrapper Div -->
    <div class="px-10">

        <!-- Navbar -->
        <nav class="sticky top-0 bg-white justify-center flex px-5 items-center border-b border-black/10 mb-10 flex-col lg:flex-row md:h-25 lg:text-lg xl:text-xl">
            <div class="md:absolute md:top-0 md:left-0">
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/TPEx.png') }}" class="w-25" alt="" />
                </a>
            </div>

            <div class="font-bold md:space-x-6 flex flex-col md:flex-row text-center">
                <a href="/items" class="px-3 py-1 rounded-lg hover:bg-neutral-100 transition-colors duration-300">Browse Items</a>
                <a href="/inventory" class="px-3 py-1 rounded-lg hover:bg-neutral-100 transition-colors duration-300">My Inventory</a>
                <a href="/orders" class="px-3 py-1 rounded-lg hover:bg-neutral-100 transition-colors duration-300">Manage Orders</a>
            </div>

            <div class="md:top-0 md:right-0 md:absolute md:h-25 flex items-center flex-col lg:flex-row justify-center">
                @guest
                    <a href="/login" class="px-3 py-1 rounded-lg hover:bg-gray-200 transition-colors duration-300">Log In <i class="fa fa-right-to-bracket"></i></a>
                @endguest
                @auth
                    @if (Auth::user()->isAdmin())
                        <a href="/admin" class="px-3 py-1 rounded-lg hover:bg-neutral-100 transition-colors duration-300 cursor-pointer">Admin Controls</a>
                    @endif
                    <button type="submit" form="logout" class="px-3 py-1 rounded-lg hover:bg-neutral-100 transition-colors duration-300 cursor-pointer">Log Out <i class="fa fa-right-from-bracket"></i></a>
                    <form id="logout" action="/logout" method="POST">
                        @csrf
                    </form>
                @endauth
            </div>

        </nav>

        <!-- Main -->
        <main class="mb-20">
            {{ $slot }}
        </main>
        <footer class="border-t border-black/10 fixed bottom-0 py-3 w-full text-center bg-white">
            &copy;TPEx 2025
        </footer>
    </div>

</body>

</html>