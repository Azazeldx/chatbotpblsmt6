<div class="flex flex-col gap-20 lg:!px-20 lg:!py-12 md:!px-16 md:!py-12 px-8 py-6">
    {{-- Header --}}
    <div class="flex flex-col text-left md:text-center" data-aos="fade-up">
        <h2 class="mb-2 text-4xl font-semibold sm:text-6xl text-secondary-500">About Cre:Ha</h2>
        <h3 class="mb-4 text-xl font-semibold lg:text-2xl text-secondary-500">|Cre·a·tor| |Ha·ichi(配置)|</h3>
        <div class="text-lg font-normal lg:text-xl">
            <p>Makna Creator: Menciptakan Karya yang Direalisasikan atau Diperkenalkan.</p>
            <p>Makna Haichi: bermakna “Showcasing” atau menampilkan.</p>
            <b>Dengan demikian, kami adalah komunitas yang secara aktif memfasilitasi para creator, khususnya di Bali, untuk memamerkan karya original mereka.</b>
        </div>
    </div>

    {{-- Vision --}}
    <div class="flex flex-col items-center gap-16 md:flex-row" data-aos="fade-up">
        <!-- Image -->
        <div class="items-center justify-center hidden w-full mb-6 lg:flex md:flex md:w-1/2 md:mb-0">
            <img src="{{ Storage::url("others/Visi.webp") }}" alt="Visi.webp" class="drop-shadow-md rounded-full w-2/3">
        </div>
        <!-- Description -->
        <div class="flex flex-col items-start w-full text-left md:w-1/2">
            <h2 class="mb-4 text-4xl font-semibold sm:text-6xl text-secondary-500">Our Vision</h2>
            <p class="text-lg text-gray-600 lg:text-xl md:text-lg">
                Menyediakan wadah untuk creator di Indonesia, khususnya di Bali, untuk merealisasikan dan memperkenalkan karya mereka kepada masyarakat luas.
            </p>
        </div>
    </div>

    {{-- Mission --}}
    <div class="flex flex-col items-center gap-16 md:flex-row" data-aos="fade-up">
        <!-- Description -->
        <div class="flex flex-col items-start w-full text-left md:w-1/2">
            <h2 class="mb-4 text-4xl font-semibold sm:text-6xl text-secondary-500">Our Mission</h2>
            <ul class="space-y-2 text-lg text-gray-600 list-disc lg:text-xl md:text-lg">
                <li class="flex gap-2 mt-2">
                    <span>Menggali potensi para creator di Bali dan meningkatkan peluang mereka untuk hidup dari karya kreatif mereka.</span>
                </li>
                <li class="flex gap-2 mt-2">
                    <span>Memperkenalkan para creator kepada khalayak yang lebih luas dan mendidik masyarakat tentang pentingnya orisinalitas karya.</span>
                </li>
                <li class="flex gap-2 mt-2">
                    <span>Menciptakan ruang untuk diskusi, kolaborasi, dan kompetisi yang sehat guna mengembangkan karya-karya berkualitas yang nanti dapat diakui secara internasional.</span>
                </li>
            </ul>
        </div>
        <!-- Image -->
        <div class="items-center justify-center hidden w-full mb-6 lg:flex md:flex md:w-1/2 md:mb-0">
            <img src="{{ Storage::url("others/Misi.webp") }}" alt="Misi.webp" class="drop-shadow-md rounded-full w-2/3">
        </div>
    </div>
</div>
