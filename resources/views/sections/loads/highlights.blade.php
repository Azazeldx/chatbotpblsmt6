{{-- < lg --}}
<div class="w-full mx-auto aspect-[16/9] relative block lg:hidden">
    <div id="default-carousel" class="relative w-full h-full" data-carousel="slide">

        <!-- Carousel wrapper -->
        <div class="relative w-full aspect-[16/9] overflow-hidden">
            @foreach ($data['loads'][$section->dataset->variable_name] as $key => $item)
                <div class="hidden duration-1000 ease-out" data-carousel-item>
                    <x-links.detail
                        category='{{ $item->category->category_name }}'
                        slug='{{ $item->slug }}'
                        class='relative'
                        has_detail_page='{{ $item->category->detail_page ? true : false }}'
                    >
                        <img src="{{ Storage::url($item->cover?->path) }}" class="block object-cover w-full h-full" alt="Image {{ $item->cover?->alt ?? $item->title }}">
                        <div class="absolute top-0 left-0 w-full overflow-hidden aspect-[16/9] z-[90] flex flex-col items-center justify-end p-6 text-center text-white bg-black/25">
                            <div class="w-full pb-0 sm:pb-6 md:pb-10">
                                <h2 class="w-full mx-auto mb-0 text-xl font-bold sm:w-4/5 md:w-3/4 sm:text-3xl md:text-4xl line-clamp-2">{{ $item->title }}</h2>
                            </div>
                        </div>
                    </x-links.detail>
                </div>
            @endforeach
        </div>

        <!-- Slider indicators (Hidden on Mobile & Tablet) -->
        <div class="absolute z-[100] hidden sm:flex space-x-3 -translate-x-1/2 bottom-5 left-1/2 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                data-carousel-slide-to="3"></button>
        </div>

        <!-- Slider controls -->
        <div class="hidden lg:block">
            <button type="button"
                class="absolute top-0 left-0 z-[100] flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 right-0 z-[100] flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70">
                    <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>
</div>

{{-- > lg --}}
{{-- @dd($data['loads'][$section->dataset->variable_name]) --}}
<div class="lg:!px-20 lg:!py-12 md:!px-16 md:!py-12 px-2 py-4 mx-auto max-w-screen-3xl hidden lg:block">
    <!-- Section Title -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="w-full text-4xl font-semibold text-center">{{ $section->dataset->category->category_name }} Sorotan</h1>
    </div>

    <!-- Card Layout -->
    <div class="flex flex-col gap-8 lg:flex-row">
        <!-- Tall Left Card -->
        <div class="relative group rounded-lg shadow-md overflow-hidden lg:w-1/2 max-h-[550px]">
            @php
                $first = $data['loads'][$section->dataset->variable_name]->first();
            @endphp
            @if ($first != null)
            <x-links.detail
                category='{{ $first->category->category_name }}'
                slug='{{ $first->slug }}'
                class=''
                has_detail_page='{{ $first->category->detail_page ? true : false }}'
            >
                <img
                    src="{{ Storage::url($first->cover?->path) }}"
                    alt="{{ $first->cover?->alt ?? $first->title }}"
                    class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105"
                >
                <div class="absolute inset-0 flex flex-col items-start justify-end p-4 text-left text-white bg-black/25">
                    <h5 class="mb-2 text-4xl font-bold line-clamp-3">{{ $first->title }}</h5>
                    <div class="flex w-full mb-2 overflow-hidden flex-nowrap">
                        @foreach ($first->tags as $tag)
                            <x-links.tag search="{{ $data['navigation']['search'] ? true : false }}" category='{{ $first->category->slug }}' tag='{{ $tag->slug }}' />
                        @endforeach
                    </div>
                    <p class="text-sm">{{ date('d/m/Y', strtotime($first->published_at)) }}</p>
                </div>
            </x-links.detail>
            @endif
        </div>

        <!-- Right Column: 3 Small Cards with Image and Text -->
        <div class="flex flex-col gap-4 lg:w-1/2">
            @foreach ($data['loads'][$section->dataset->variable_name] as $key => $item)
                @if ($key > 0)
                    <div class="flex flex-col gap-4 overflow-hidden lg:flex-row h-1/3">
                        <!-- Image Section -->
                        <x-links.detail
                            category='{{ $item->category->slug }}'
                            slug='{{ $item->slug }}'
                            class='block w-full h-full lg:w-1/2'
                            has_detail_page='{{ $item->category->detail_page ?? false }}'
                        >
                            <div class="relative flex-none w-full h-full overflow-hidden rounded-lg group">
                                <img src="{{ Storage::url($item->cover?->path) }}" alt="{{ $item->cover?->alt ?? $item->title }}" class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105 ">
                                <div class="absolute inset-0 bg-black/25"></div>
                            </div>
                        </x-links.detail>
                        <!-- Text Section -->
                        <div class="flex flex-col justify-between w-full">
                            <div>
                                <h5 class="text-xl font-semibold line-clamp-1">{{ $item->title }}</h5>
                                <div class="flex w-full overflow-hidden flex-nowrap">
                                    @foreach ($item->tags as $tag)
                                        <x-links.tag search="{{ $data['navigation']['search'] ? true : false }}" category='{{ $item->category->slug }}' tag='{{ $tag->slug }}' />
                                    @endforeach
                                </div>
                                <p class="line-clamp-2">{{ $item->preview_content }}</p>
                            </div>
                            <p class="text-sm">{{ date('d/m/Y', strtotime($item->published_at)) }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
