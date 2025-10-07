@props(["colour"=>"","href"=>"","icon"=>"search"])
<a href="{{ $href }}" class="h-full hover:-translate-y-2 transition-translate duration-300">
    <div {{ $attributes->merge(["class"=>"rounded-lg p-5 h-full flex flex-col items-center justify-center max-w-100 lg:max-w-1000 m-auto gap-5"]) }} >
        <h3 class="text-center text-3xl font-bold">{{ $slot }}</h3>
        <i class="fa fa-{{ $icon }} text-3xl"></i>
    </div>
</a>