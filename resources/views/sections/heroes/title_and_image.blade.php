<!-- ============================================================ -->
 <!-- ini versi sebelumnya -->
<!-- ============================================================ -->

<!-- 
<div class="lg:!px-20 lg:!py-12 md:!px-16 md:!py-12 px-8 py-6" data-aos="fade-up">
    <div class="flex flex-wrap items-center justify-center mx-auto">
         Left Side: Contact Form 
        <div class="items-center w-full mb-6 lg:w-1/2 lg:mb-0">
             Text Section
            <h2 class="mb-4 text-4xl font-semibold sm:text-6xl">
                <span class="text-secondary-500">Cre:Ha</span> Project Connecting Creator
            </h2>
            <p class="mb-4 text-lg text-gray-600">
                Kami berkomitmen menghadirkan wadah-wadah yang akan menjadi ekonomi kreatif pop culture!!
            </p>
            <a href="#"
                class="flex items-center justify-between w-56 px-4 py-2 text-white transition-transform transform rounded-lg shadow-md bg-secondary-500 hover:scale-105">
                <span class="truncate text-semibold">Baca selengkapnya</span>
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </div>

        Right Side: Image
        <div class="items-end justify-end hidden w-full lg:flex lg:w-1/3">
            <img src="{{ Storage::url("others/avatar.webp") }}" alt="Contact Us Image" class="drop-shadow-md">
        </div>
    </div>
</div> 
-->


<!-- ini setelah perubahan -->


<div class="w-full mx-auto h-[20vh] sm:h-[30vh] lg:h-[60vh] relative">
    <div id="default-carousel" class="relative w-full h-full" data-carousel="slide">

        {{-- Tagline --}}
        <!-- <div class="absolute top-0 left-0 w-full lg:h-svh overflow-hidden aspect-[16/9] z-[90] flex flex-col items-center justify-center py-6 px-[10%] text-center text-white bg-black/25">
            <h2 class="mb-2 text-3xl font-bold sm:mb-4 md:text-5xl lg:text-7xl">Welcome To {{ $data['site_name'] }}</h2>
            <p class="hidden max-w-4xl mb-4 sm:block md:text-xl lg:text-2xl">
                Kami adalah komunitas pop culture yang secara aktif mendukung para kreator, terutama di Bali, untuk memperkenalkan dan menjual karya mereka! Creator yang kami wadahi adalah para pembuat ilustrasi, cosplay, komik, animasi, game, dan pastinya mewadahi para fans dari pop culture itu sendiri.
            </p>
        </div> -->

        @php
            $images = Storage::disk('public')->allFiles('aboutus');
            foreach ($images as $key => $item) {
                $image['path'] = $item;
                $image['info'] = Str::substr($item, 9);
                $images[$key] = $image;
            }
            $count = count($images);
        @endphp

        <!-- Carousel wrapper -->
        <div class="relative w-full h-full overflow-hidden">
                    <img src="{{ Storage::url($image['path']) }}" class="block object-cover w-full h-full" alt="{{ $image['info'] }}">
        </div>

        <!-- Slider indicators (Hidden on Mobile & Tablet) -->
        <!-- <div class="absolute z-[100] hidden sm:flex space-x-3 -translate-x-1/2 bottom-5 left-1/2 rtl:space-x-reverse">
            @foreach ($images as $key => $image)
                <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="{{ $image['info'] }}" data-carousel-slide-to="{{ $key }}"></button>
            @endforeach
        </div> -->

        <!-- Slider controls -->
        <!-- <div class="hidden lg:block">
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
        </div> -->
    </div>
</div>
