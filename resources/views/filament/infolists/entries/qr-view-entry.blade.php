<div>
    @php
        $uuid = $record->uuid;
    @endphp
    <div class="mx-auto">
        <img class="w-92" src="data:image/png;base64,{!! base64_encode(
            QrCode::format('png')->merge(public_path('/images/hoplun_logo.png'), 0.3, true)->errorCorrection('H')->eye('circle')->style('round')->size(256)->margin(2)->color(254, 249, 4)->backgroundColor(244, 134, 163)->generate(config('falcon.base_frontend') . $uuid),
        ) !!}">

        <br>
        <a href="data:image/png;base64,{!! base64_encode(
            QrCode::format('png')->merge(public_path('/images/hoplun_logo.png'), 0.3, true)->errorCorrection('H')->eye('circle')->style('round')->size(1024)->margin(2)->color(254, 249, 4)->backgroundColor(244, 134, 163)->generate(config('falcon.base_frontend') . $uuid),
        ) !!}" download="{{ $record->name }}.png">
            <x-filament::button icon="tabler-download" icon-position="before" color="warning">
                Download
            </x-filament::button>
        </a>
    </div>

</div>
