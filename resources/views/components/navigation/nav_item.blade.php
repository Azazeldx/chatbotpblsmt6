@props([
    'slug' => '/',
    'url' => null
])

@php
    // Item aktif = tautan internal yang cocok dengan route saat ini.
    // Kasus khusus: halaman beranda dapat diakses lewat route '/' (root) maupun route ber-slug home,
    // jadi keduanya dianggap aktif untuk item beranda.
    $homeSlug = config('general-settings.navigation.home.slug');
    $isActive = $url === null && (
        request()->routeIs($slug)
        || (request()->routeIs('/') && $slug === $homeSlug)
    );
@endphp

<li class="w-full px-4 md:px-0 md:w-fit">
    <a href="{{ $url ?? route($slug) }}"
        target="{{ $url != null ? '_blank' : '_parent' }}"
        @class([
            'hover:block block font-semibold md:hover:scale-110 hover:font-bold hover:text-[#2563eb] hover:underline underline-offset-4 decoration-2 transition-colors py-2 px-8 md:py-0 md:px-0',
            'font-bold underline text-[#2563eb]' => $isActive
        ])
    >{{ $slot }}</a>
</li>
