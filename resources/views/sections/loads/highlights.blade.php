{{-- Artikel Sorotan — kartu utama + daftar artikel pendukung (desain modern) --}}
@php
    $items    = $data['loads'][$section->dataset->variable_name];
    $featured = $items->first();
    $rest     = $items->slice(1, 3);
@endphp

@if ($featured)
<section class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:!px-20 pt-10 lg:pt-14 pb-4" data-aos="fade-up">
    <div class="grid lg:grid-cols-5 gap-6">

        <!-- Kartu utama -->
        <div class="lg:col-span-3">
            <div class="group relative rounded-3xl overflow-hidden shadow-xl h-full min-h-[340px] lg:min-h-[460px]">
                <x-links.detail
                    category='{{ $featured->category->slug }}'
                    slug='{{ $featured->slug }}'
                    class='absolute inset-0 z-20'
                    has_detail_page='{{ $featured->category->detail_page ? true : false }}'
                />
                <img src="{{ Storage::url($featured->cover?->path) }}"
                     alt="{{ $featured->cover?->alt ?? $featured->title }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                     loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                <div class="relative z-10 flex flex-col justify-end h-full p-6 lg:p-8 text-white">
                    <span class="inline-flex self-start items-center text-[10px] font-bold uppercase tracking-widest bg-[#2563eb] text-white px-3 py-1 rounded-full mb-4">
                        Terkini
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold leading-tight line-clamp-3 mb-3">
                        {{ $featured->title }}
                    </h2>
                    <p class="text-xs text-white/75 font-medium tracking-wide">
                        {{ date('d/m/Y', strtotime($featured->published_at)) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Daftar artikel pendukung -->
        <div class="lg:col-span-2 flex flex-col gap-5">
            @foreach ($rest as $item)
                <div class="group relative flex gap-4 items-start bg-white rounded-2xl border border-slate-100 shadow-sm p-3 transition hover:shadow-lg">
                    <x-links.detail
                        category='{{ $item->category->slug }}'
                        slug='{{ $item->slug }}'
                        class='absolute inset-0 z-20'
                        has_detail_page='{{ $item->category->detail_page ? true : false }}'
                    />
                    <div class="flex-shrink-0 w-28 h-24 rounded-xl overflow-hidden">
                        <img src="{{ Storage::url($item->cover?->path) }}"
                             alt="{{ $item->cover?->alt ?? $item->title }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             loading="lazy" decoding="async">
                    </div>
                    <div class="flex flex-col min-w-0 py-0.5">
                        <h3 class="font-bold text-slate-900 text-[15px] leading-snug line-clamp-2 transition-colors group-hover:text-[#2563eb]">
                            {{ $item->title }}
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mt-1">
                            {{ $item->preview_content }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium tracking-wide mt-2">
                            {{ date('d/m/Y', strtotime($item->published_at)) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
