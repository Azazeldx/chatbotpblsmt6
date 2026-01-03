<div class="flex flex-col overflow-hidden transition bg-white rounded-lg shadow group hover:shadow-lg h-full">
    <div class="relative grow">
        <x-links.detail 
            category='{{ $item->category->slug }}' 
            slug='{{ $item->slug }}' 
            class='absolute inset-0 z-10' 
            has_detail_page='{{ $item->category->detail_page ? true : false }}' 
        />
        
        <div class="overflow-hidden">
            <img src="{{ Storage::url($item->cover?->path) }}" 
                 alt="{{ $item->cover?->alt ?? $item->title }}" 
                 class="object-cover w-full h-48 transition-transform duration-300 group-hover:scale-105" 
                 loading="lazy">
        </div>

        <div class="p-4 flex flex-col h-full">
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach ($item->tags as $tag)
                    <span class="text-[10px] uppercase font-bold tracking-wider bg-blue-50 text-blue-600 px-2 py-1 rounded">
                        {{ $tag->tag_name }}
                    </span>
                @endforeach
            </div>

            <h3 class="mb-1 font-bold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">
                {{ $item->title }}
            </h3>

            <span class="text-xs text-gray-400 mb-2">
                    {{ \Carbon\Carbon::parse($item->published_at)->diffForHumans() }}
            </span>

            <p class="mb-4 text-sm text-gray-600 line-clamp-3">
                {{ $item->preview_content }}
            </p>

            <span class="text-sm font-semibold text-blue-600 group-hover:underline">
                    Selengkapnya →
            </span>
        </div>
    </div>
</div>