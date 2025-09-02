@props(["item", "linkto"=>null])
@if (!is_null($linkto))
<a href="{{$linkto}}"  class="w-16 h-16 self-center"><img src="{{  '/images/items/' . $item . '.png' }}" onerror="this.src = '/images/TPEx.png'"/></a>
@else
<img src="{{  '/images/items/' . $item . '.png' }}" onerror="this.src = '/images/TPEx.png'" class="w-16 h-16 self-center"/>
@endif
