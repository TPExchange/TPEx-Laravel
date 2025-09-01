@props(["items", "name" => "item", "item" => null])

<input onchange='(@json($items).includes(this.value) ? $(this).removeClass("bg-red-300") : $(this).addClass("bg-red-300"))' {{ $attributes->merge([
    "list" => "item-list",
    "name" => $name,
    "class" => "px-1 border border-neutral-200 w-sm rounded-sm",
    "value" => $item ?? "",
    "oninput" => "checkRestricted();"
]) }} />
<datalist id="item-list"  autocomplete="off">
    @foreach ($items as $item)
        <option value="{{ $item }}">{{ ucwords(str_replace("_", " ", $item)) }}</option>
    @endforeach
</datalist>
