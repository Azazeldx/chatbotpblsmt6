<footer class="lg:!px-40 lg:!py-12 md:!px-20 md:!py-12 px-8 py-6 border-t-2" data-aos="fade-up">
    <div class="grid grid-cols-2 gap-8 md:grid-cols-3 lg:grid-cols-4">

        <!-- Logo Section (No Stretching, Center on Mobile, Left on Tablet/Desktop) -->
        <div class="flex col-span-2 mb-6 md:justify-center md:col-span-3 lg:col-span-1">
            <img class="h-auto max-w-[100px] md:max-w-[122px] lg:max-h-[100px] lg:max-w-[120px]" src="{{ asset('storage/others/logoPNB.png') }}" alt="{{ $data['site_name'] }}">           
        </div>

        <!-- Discover Section -->
        <div class="mb-6">
            <a class="text-xl font-semibold md:text-2xl">Discover</a>
            <ul class="flex flex-col mt-3 space-y-2">
                @if ($data['navigation']['home'])
                    <x-footer.nav_item slug="{{ $data['navigation']['home']['slug'] }}">
                        {{ $data['navigation']['home']['title'] }}
                    </x-footer.nav_item>
                @endif
                @foreach ($data['navigation']['nav_items'] as $navItem)
                    @if ($navItem['type'] == 'link')
                        <x-footer.nav_item url="{{ $navItem['link']['url'] }}">
                            {{ $navItem['link']['label'] }}
                        </x-footer.nav_item>
                    @else
                        <x-footer.nav_item slug="{{ $navItem['page']['slug'] }}">
                            {{ $navItem['page']['title'] }}
                        </x-footer.nav_item>
                    @endif
                @endforeach
            </ul>
        </div>

        <!-- For Businesses Section -->
        <div class="mb-6">
            <a class="text-xl font-semibold md:text-2xl">For Businesses</a>
            <ul class="flex flex-col mt-3 space-y-2 text-base md:text-lg">
                @if ($data['contacts']['email'])
                    <x-footer.contact_item url="mailto:{{ $data['contacts']['email'] }}">
                    {{ $data['contacts']['email'] }}
                    </x-footer.contact_item>
                @endif
                @if ($data['contacts']['phone'])
                    <x-footer.contact_item url="tel:{{ $data['contacts']['phone'] }}">
                    {{ $data['contacts']['phone'] }}
                    </x-footer.contact_item>
                @endif
                @if ($data['location']['address'])
                    <x-footer.contact_item url="{{ $data['location']['url'] }}">
                    {{ $data['location']['address'] }}
                    </x-footer.contact_item>
                @endif
            </ul>
        </div>

        <!-- Available On Section -->
        <div class="col-span-2 md:mb-6 md:col-span-1">
            <a class="text-xl font-semibold md:text-2xl">Available On</a>
            <ul class="flex gap-3 mt-3">
                @if ($data['social_network'])
                    @foreach ($data['social_network'] as $key => $value)
                        @if ($value['url'])
                            <x-footer.social_network_item title="{{ $value['label'] }}" url="{{ $value['url'] }}" brand="{{ $key }}"/>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>

    <!-- Footer Bottom Section -->
    <div class="flex flex-col items-start justify-center pt-4 mt-6 border-t border-gray-300 md:items-center">
        <p class="text-sm text-gray-600">Copyright © {{ date('Y') }} - {{ $data['site_name'] }}</p>
    </div>
</footer>
