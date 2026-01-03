<div class="w-full mx-auto h-[30vh] sm:h-[50vh] lg:h-[60vh] relative">
    <div id="default-carousel" class="relative w-full h-full" data-carousel="slide">
        @php
            $images = Storage::disk('public')->allFiles('homepage');
            foreach ($images as $key => $item) {
                $image['path'] = $item;
                $image['info'] = Str::substr($item, 9);
                $images[$key] = $image;
            }
            $count = count($images);
        @endphp

        <!-- Carousel wrapper -->
        <div class="relative w-full h-full overflow-hidden">
            @foreach ($images as $image)
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="{{ Storage::url($image['path']) }}" class="block object-cover w-full h-full" alt="{{ $image['info'] }}">
                </div>
            @endforeach
        </div>

        <!-- Slider indicators (Hidden on Mobile & Tablet) -->
        <div class="absolute z-[100] hidden sm:flex space-x-3 -translate-x-1/2 bottom-5 left-1/2 rtl:space-x-reverse">
            @foreach ($images as $key => $image)
                <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="{{ $image['info'] }}" data-carousel-slide-to="{{ $key }}"></button>
            @endforeach
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
