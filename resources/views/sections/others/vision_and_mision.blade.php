<!-- ======================================================== -->
 <!-- ini versi sebelumnya -->
<!-- ======================================================== -->
<!--
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
         Image
        <div class="items-center justify-center hidden w-full mb-6 lg:flex md:flex md:w-1/2 md:mb-0">
            <img src="{{ Storage::url("others/Visi.webp") }}" alt="Visi.webp" class="drop-shadow-md rounded-full w-2/3">
        </div>
        Description
        <div class="flex flex-col items-start w-full text-left md:w-1/2">
            <h2 class="mb-4 text-4xl font-semibold sm:text-6xl text-secondary-500">Our Vision</h2>
            <p class="text-lg text-gray-600 lg:text-xl md:text-lg">
                Menyediakan wadah untuk creator di Indonesia, khususnya di Bali, untuk merealisasikan dan memperkenalkan karya mereka kepada masyarakat luas.
            </p>
        </div>
    </div>

    {{-- Mission --}}
    <div class="flex flex-col items-center gap-16 md:flex-row" data-aos="fade-up">
        Description
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
         Image
        <div class="items-center justify-center hidden w-full mb-6 lg:flex md:flex md:w-1/2 md:mb-0">
            <img src="{{ Storage::url("others/Misi.webp") }}" alt="Misi.webp" class="drop-shadow-md rounded-full w-2/3">
        </div>
    </div>
</div>
-->
<!-- ini setelah perubahan -->
     <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200&h=400&fit=crop') center/cover;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .department-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .department-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: #3b4279;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2d3158;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            border-bottom: 3px solid #3b4279;
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
            background-color: rgba(255, 255, 255, 0.95);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #3b4279;
        }

        .circular-img {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #3b4279;
        }

        nav {
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .logo-img {
            width: 40px;
            height: 40px;
        }

        .footer-link {
            color: #a0aec0;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #3b4279;
        }

        .active {
            color: #3b4279;
            font-weight: 600;
        }
    </style>
    <!-- Cerita Kita Section -->
    <section id="tentang" class="py-16 px-4 max-w-7xl mx-auto" data-aos="fade-up">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="section-title">Cerita Kita</h2>
                <p class="text-gray-600 mt-4 mb-4 font-semibold">Direktur Politeknik Negeri Bali</p>
                <h3 class="text-2xl font-bold mb-4">I Nyoman Abdi, SE., M.Com</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Puji syukur kehadiapan Tita Tyang Hyang Widhi Wasa atas pujurishan, karena sejak awal tahun 2000 Politeknik Negeri Bali telah berkembang. Kami memulai dengan visi untuk menjadi lembaga pendidikan Vokasi Terdepan yang dipercaya masyarakat dari misi sebagai lembaga pendidikan Vokasi Terdepan yang menghasilkan lulusan Profesional yang memiliki daya saing internasional dengan budi pekerti luhur.
                </p>
            </div>
            <div class="flex justify-center">
                <img src="{{ Storage::url('others/direkturPNB.webp') }}"
                 alt="Direktur" class="rounded-lg w-80 h-80 object-cover">
            </div>
        </div>
    </section>

     <!-- Visi Section -->
    <section class="py-16 px-4 max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="flex justify-center">
                <img src="{{ Storage::url('others/illustrasi.webp') }}"
                 alt="Direktur" class="rounded-lg w-80 h-80 object-cover">
            </div>
            <div>
                <h2 class="text-4xl font-bold mb-6 inline-block border-b-4 border-[#3b4279] pb-2">Visi</h2>
                <p class="text-gray-700 leading-relaxed text-lg">
                    Menjadi Lembaga Pendidikan Tinggi Vokasi Terdepan Penghubil Lulusan Profesional Berdaya Saing Internasional Pada Tahun 2025
                </p>
            </div>
        </div>
    </section>

    <!-- Misi Section -->
    <section class="py-16 px-4 max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="section-title">Misi</h2>
                <ul class="mt-6 space-y-4 list-disc list-outside pl-6 text-gray-700 text-lg leading-relaxed">
                    <li>Menyelenggarakan pendidikan vokasi yang dapat diakses secara merata dan merata bagi masyarakat</li>
                    <li>Menyelenggarakan pendidikan vokasi yang berkarakter bangsa dengan standar mutu nasional dan regional di Asia-Pasifik</li>
                    <li>Menyelenggarakan penelitian bertaraf internasional di bidang ilmu dan teknologi terapan</li>
                    <li>Menyelenggarakan pengabdian kepada masyarakat berbasis penerapan ilmu pengetahuan dan teknologi</li>
                    <li>Menyelenggarakan kerjasama di kawasan ASPAC</li>
                    <li>Mengembangkan sistem tata kelola yang inovatif, transparan, dan akuntabel yang didukung oleh sumber daya berstandar internasional</li>
                    <li>Membangun keunggulan institusi berorientasi pariwisata</li>
                </ul>
            </div>
            <div class="flex justify-center">
                <img src="{{ Storage::url('others/illustrasi2.webp') }}"
                 alt="Direktur" class="rounded-lg w-85 h-85 object-cover">
            </div>
        </div>
    </section>