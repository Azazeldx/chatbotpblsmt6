<div class="group flex h-full max-w-[400px] flex-col overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-gray-100 mx-auto" data-aos="zoom-in">
    
    <div class="relative aspect-video overflow-hidden">
        <img src="{{ Storage::url($item->cover?->path) }}"
             alt="{{ $item->title }}"
             class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
             loading="lazy" decoding="async" width="400" height="225">
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
    </div>

    <div class="flex grow flex-col p-7">
        
        <h3 class="mb-1 line-clamp-2 min-h-[3rem] text-3xl font-bold leading-tight text-gray-800 transition-colors group-hover:text-[#2563eb]">
            {{ $item->title }}
        </h3>

        <p class="mb-8 line-clamp-3 text-base leading-relaxed text-gray-600">
            {{ $item->preview_content ?? 'Jelajahi keunggulan Jurusan ' . $item->title . ' di Politeknik Negeri Bali untuk masa depan cerah.' }}
        </p>

        <div class="mt-auto">
            <x-links.detail 
                category='{{ $item->category->slug }}' 
                slug='{{ $item->slug }}' 
                has_detail_page='{{ $item->category->detail_page ? true : false }}'
                class="block w-full rounded-xl bg-[#2563eb] px-6 py-4 text-center text-sm font-bold uppercase tracking-wider text-white shadow-lg transition-all active:scale-95 hover:bg-[#1d4ed8] hover:shadow-[#2563eb]/30"
            >
                Lihat Lengkap &rarr;
            </x-links.detail>
        </div>
    </div>
</div>