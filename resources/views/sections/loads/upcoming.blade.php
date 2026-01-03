{{-- < lg --}}
{{-- <div class="w-full mx-auto aspect-[16/9] relative block lg:hidden">
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
</div> --}}

{{-- > lg --}}
{{-- <div class="lg:!px-20 lg:!py-12 md:!px-16 md:!py-12 px-2 py-4 mx-auto max-w-screen-3xl hidden lg:block">
    <!-- Section Title -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="w-full text-4xl font-semibold text-center">{{ $section->dataset->category->category_name }} Sorotan</h1>
    </div>
    <!-- Carousel Wrapper -->
    <div id="default-carousel" class="relative w-full" data-carousel="slide">

        <!-- Carousel wrapper -->
        <div class="relative min-h-[700px] sm:min-h-[400px] overflow-hidden px-6 sm:px-8 md:px-12">
            @foreach ($data['loads'][$section->dataset->variable_name] as $item)
                <div class="hidden duration-1000 ease-out" data-carousel-item>
                    <div class="flex-shrink-0 w-full">
                        <!-- Flex direction changes based on screen size -->
                        <div class="flex flex-col items-center h-full gap-8 px-20 sm:flex-row-reverse">
                            <!-- Image Section (now comes after the title and content on mobile) -->
                            <div class="flex justify-end min-w-fit">
                                <div class="relative overflow-hidden rounded-lg min-w-fit group">
                                    <img src="{{ Storage::url($item->cover?->path) }}" alt="{{ $item->cover?->alt ?? $item->title }}" class="object-cover aspect-[1/1] h-[300px] sm:h-[400px] md:h-[400px] lg:h-[400px] rounded-lg group-hover:scale-105 ">
                                <div class="absolute inset-0 bg-black/25"></div>
                                </div>
                            </div>

                            <!-- Text Section -->
                            <div class="flex-grow">
                                <h2 class="mb-2 text-2xl font-semibold sm:text-4xl">{{ $item->title }}</h2>
                                <p class="mb-4 text-lg text-justify text-gray-600 line-clamp-6 indent-4">
                                    {{ $item->preview_content }}
                                </p>
                                <ul class="flex-row items-center gap-2 mb-4 nav">
                                    <p class="m-0 text-lg font-semibold">
                                        {{ date('d F Y', strtotime($item->published_at)) }}</p>
                                </ul>
                                <x-links.detail
                                    category='{{ $item->category->slug }}'
                                    slug='{{ $item->slug }}'
                                    class='flex items-center justify-between w-56 px-4 py-2 text-white transition-transform transform rounded-lg shadow-md hover:scale-105 bg-secondary-500'
                                    has_detail_page='{{ $item->category->detail_page ?? false }}'
                                >
                                    <span class="truncate text-semibold">Baca selengkapnya</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </x-links.detail>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Slider indicators -->
        <div class="absolute z-[100] flex space-x-3 -translate-x-1/2 bottom-5 left-1/2 rtl:space-x-reverse">
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
        <button type="button"
            class="absolute top-0 left-0 z-40 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full dark:bg-white/30 bg-gray-800/30 dark:group-hover:bg-white/50 group-hover:bg-gray-800/60 group-focus:ring-4 dark:group-focus:ring-white group-focus:ring-gray-800/70">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 right-0 z-40 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full dark:bg-white/30 bg-gray-800/30 dark:group-hover:bg-white/50 group-hover:bg-gray-800/60 group-focus:ring-4 dark:group-focus:ring-white group-focus:ring-gray-800/70">
                <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
</div> --}}

