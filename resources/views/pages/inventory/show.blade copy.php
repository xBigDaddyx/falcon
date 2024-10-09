<x-falcon::app-layout>
    @push('styles')
        <style>
            .watermarked {
                position: relative;
            }

            .watermarked:after {
                content: "";
                display: block;
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0px;
                left: 0px;
                background-image: url("http://teresa.test/storage/images/logo/hoplun_logo.bmp");
                background-size: 100px 100px;
                background-position: 30px 30px;
                background-repeat: no-repeat;
                opacity: 0.7;
            }
        </style>
    @endpush
    <div class="bg-white">
        <div
            class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
            <!-- Product details -->
            <div class="lg:max-w-lg lg:self-end">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2">
                        <li>
                            <div class="flex items-center text-sm">
                                <a href="#" class="font-medium text-gray-500 hover:text-gray-900">Falcon</a>
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                    class="ml-2 h-5 w-5 flex-shrink-0 text-gray-300">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center text-sm">
                                <a href="#" class="font-medium text-gray-500 hover:text-gray-900">Inventories</a>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="mt-4">
                    <h1 class="text-3xl font-bold tracking-tight text-primary-500 sm:text-4xl flex">{{ $item->name }}

                </div>


                <section aria-labelledby="information-heading" class="mt-4">
                    <h2 id="information-heading" class="sr-only">Inventory information</h2>

                    <div class="flex items-center">
                        <p class="text-lg text-gray-900 sm:text-xl">{{ $item->model }}</p>

                        <div class="ml-4 border-l border-gray-300 pl-4">
                            <div class="flex items-center">
                                <p>Serial</p>
                                <p class="ml-2 text-sm text-gray-500">{{ $item->serial }}</p>
                            </div>
                        </div>
                        <div class="ml-4 pl-4 hidden lg:block">
                            <img src="{{ asset('storage/' . $item->manufacture->logo) }}" alt=""
                                style="height: 56px;">
                        </div>
                        <div class="ml-4 pl-4 hidden lg:block">
                            <img src="{{ asset('storage/' . $item->asset->company->logo) }}" alt=""
                                style="height: 56px;">
                        </div>

                    </div>

                    {{-- <div class="mt-6 flex items-center">
                        <svg class="h-5 w-5 flex-shrink-0 text-green-500" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-2 text-sm text-gray-500">{{ $item->status->name }}</p>
                    </div> --}}
                </section>
            </div>

            <!-- Product image -->
            <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">

                <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg ">

                    <img src="{{ asset('storage/' . $item->pictures[0]) }}"
                        alt="Model wearing light green backpack with black canvas straps and front zipper pouch."
                        class="h-full w-full object-cover object-center" />
                </div>
            </div>

            <!-- Product form -->
            <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">

                <div class="pt-4">
                    <h2 class="text-sm font-medium text-gray-900 mb-4">Users</h2>
                    <div class="flex grid grid-cols-1 gap-x-8 gap-y-10 text-sm sm:grid-cols-2">
                        @foreach ($item->asset->users as $user)
                            <div class="flex space-x-4 text-sm text-gray-500">
                                <div class="flex-none">
                                    <img src="{{ asset('storage/' . $user->avatar_url) }}" alt=""
                                        class="h-10 w-10 rounded-full bg-gray-100" />
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $user->name }}</h3>
                                    <p><time datetime="2021-07-16">{{ $user->email }}</time></p>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>
                <section aria-labelledby="features-heading" class="relative">
                    <div class="mx-auto pb-24 pt-16 ">
                        <div class="lg:col-start-2 ">

                            <p class="mt-4 text-4xl font-bold tracking-tight text-primary-500 ">Asset Information</p>
                            <p class="mt-4 text-gray-500">Asset information of this inventory.</p>

                            <dl class="mt-10 grid grid-cols-1 gap-x-8 gap-y-10 text-sm sm:grid-cols-2">
                                <div>
                                    <dt class="font-medium text-gray-900">Asset Code</dt>
                                    <dd class="font-bold mt-2 text-primary-500">{{ $item->asset->asset_code }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Asset Type</dt>
                                    <dd class="mt-2 text-gray-500">{{ $item->asset->category->finance_asset_type }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Purchase Order</dt>
                                    <dd class="mt-2 text-gray-500">{{ $item->asset->purchase_order }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Purchased Price</dt>
                                    <dd class="mt-2 text-gray-500">
                                        {{ 'Rp ' . number_format($item->asset->purchased_price, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Purchased At</dt>
                                    <dd class="mt-2 text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->asset->purchased_at)->format('d M Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Book Value</dt>
                                    <dd class="mt-2 text-gray-500">
                                        {{ 'Rp ' . number_format($item->asset->bookValue, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Owner</dt>
                                    <dd class="mt-2 text-gray-500">{{ $item->asset->company->name }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
    <div class="bg-primary-600">

        <div class="relative mx-auto -mt-12 max-w-7xl px-4 pb-16 sm:px-6 sm:pb-24 lg:px-8 py-8">
            <div class="mx-auto max-w-2xl text-center lg:max-w-4xl">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Specifications</h2>
                <p class="mt-4 text-white">This section provides a detailed breakdown of the key specifications for
                    our laptops and personal desktops. Here, you'll find information on processors, memory, storage,
                    graphics, and connectivity options.</p>
            </div>

            <dl
                class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 sm:gap-y-16 lg:max-w-none lg:grid-cols-3 lg:gap-x-8">
                @foreach ($item->specifications as $specification)
                    <div class="border-t border-gray-200 pt-4">
                        <dt class="font-medium text-white">{{ $specification['detail_item'] }}</dt>
                        <dd class="mt-2 text-sm text-white">{{ $specification['detail_value'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</x-falcon::app-layout>
