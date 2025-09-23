@props(["items", "name" => "item", "item" => null, "class" => "px-1 border border-neutral-200 w-sm rounded-sm form-horizontal", "defer"=>null])
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<select autocomplete="off" placeholder="Enter item name... " {{ $attributes->merge([
    "name" => $name,
    "class" => "$class select2",
])}}>
    <option value=""></option>
    @foreach ($items as $this_item)
        <option value="{{ $item }}"
            @if ($item == $this_item)
                selected
            @endif
        >{{ ucwords(str_replace("_", " ", $this_item)) }}</option>
    @endforeach
</select>

@if(!$defer)
    <script>$(".select2").select2();</script>
@endif
