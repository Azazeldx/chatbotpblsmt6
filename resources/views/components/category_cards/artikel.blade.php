<div class="group relative flex flex-col h-full overflow-hidden bg-white border border-slate-100 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
    <!-- Seluruh kartu bisa diklik -->
    <x-links.detail
        category='{{ $item->category->slug }}'
        slug='{{ $item->slug }}'
        class='absolute inset-0 z-10'
        has_detail_page='{{ $item->category->detail_page ? true : false }}'
    />

    <!-- Gambar + badge kategori overlay -->
    <div class="relative overflow-hidden">
        <img src="{{ Storage::url($item->cover?->path) }}"
             alt="{{ $item->cover?->alt ?? $item->title }}"
             class="object-cover w-full h-52 transition-transform duration-500 group-hover:scale-105"
             loading="lazy" decoding="async" width="400" height="208">

        <div class="absolute top-4 left-4 z-20 flex flex-wrap gap-2">
            @foreach ($item->tags as $tag)
                <span class="text-[10px] uppercase font-bold tracking-widest bg-white/90 backdrop-blur-sm text-[#2563eb] px-3 py-1 rounded-full shadow-sm">
                    {{ $tag->tag_name }}
                </span>
            @endforeach
        </div>
    </div>

    <!-- Konten -->
    <div class="flex flex-col flex-grow p-5">
        <h3 class="mb-2 text-lg font-extrabold leading-snug text-slate-900 line-clamp-2 transition-colors group-hover:text-[#2563eb]">
            {{ $item->title }}
        </h3>

        <span class="text-[11px] font-semibold uppercase tracking-widest text-slate-400 mb-3">
            {{ \Carbon\Carbon::parse($item->published_at)->diffForHumans() }}
        </span>

        <p class="mb-5 text-sm text-slate-500 leading-relaxed line-clamp-3">
            {{ $item->preview_content }}
        </p>

        <span class="mt-auto inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-[#2563eb] transition-all group-hover:gap-2.5">
            Selengkapnya <i class="fas fa-chevron-right text-[10px]"></i>
        </span>
    </div>
</div>
