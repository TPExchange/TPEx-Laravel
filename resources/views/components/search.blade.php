@props(["action"=>"/"])
<form class="flex mb-20 flex-col w-full xs:w-xs md:w-md lg:w-lg m-auto" method="GET" action="{{ $action }}">
    <input
        class="border border-gray-400 rounded-full px-3 py-1 text-lg"
        name="q"
        id="q"
        placeholder="Search"
        autocomplete="off"
        @if (request("q"))
            value={{ request("q") }}
        @endif
        />
</form>