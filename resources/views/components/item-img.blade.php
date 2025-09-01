@props(["item"])
<img src="{{  '/images/items/' . $item . '.png' }}" onerror="this.src = '/images/TPEx.png'" class="w-16 h-16 self-center"/>