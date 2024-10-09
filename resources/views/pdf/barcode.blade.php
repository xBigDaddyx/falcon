<x-falcon::print-layout>
    <div class="grid grid-cols-12 gap-4 px-2 py-8 max-w-xl mx-auto">
        @foreach ($inventories as $item)
            <img class="h-full" src="data:image/png;base64,{!! base64_encode(
                QrCode::format('png')->merge(public_path('/images/hoplun_logo.png'), 0.3, true)->errorCorrection('H')->eye('circle')->style('round')->size(1024)->margin(2)->color(254, 249, 4)->backgroundColor(244, 134, 163)->generate(config('falcon.base_frontend') . $item->uuid),
            ) !!}">
        @endforeach
    </div>
</x-falcon::print-layout>
