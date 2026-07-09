<div class="w-full relative min-h-[420px] h-[60vh] lg:h-[72vh] overflow-hidden group">
    @php
        // Cache daftar file agar tidak scan filesystem tiap request (LCP/response time)
        $images = \Illuminate\Support\Facades\Cache::remember('hero_homepage_images', 300, function () {
            return Storage::disk('public')->allFiles('homepage');
        });
        // Ambil gambar pertama saja agar tidak bergeser (statis)
        $heroImage = count($images) > 0 ? Storage::url($images[0]) : null;
    @endphp

    @if($heroImage)
        <!-- Gambar Latar dengan Efek Modern (Zoom in sangat halus saat di-hover) -->
        <div class="absolute inset-0 transition-transform duration-[2000ms] ease-out group-hover:scale-105">
            <img src="{{ $heroImage }}" class="object-cover object-center w-full h-full" alt="Banner Utama Kabupaten Pasuruan" fetchpriority="high" decoding="async" width="1920" height="1080">
        </div>

        <!-- Gradient Overlay agar teks terbaca & terlihat premium -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>
    @else
        <!-- Placeholder bila belum ada gambar -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#1e3a8a] via-[#1e40af] to-[#0f172a]"></div>
    @endif

    <!-- Konten Hero -->
    <div class="absolute inset-0 z-20 flex flex-col items-center justify-center text-center px-4">
        <span data-aos="fade-down"
              class="inline-flex items-center gap-2 bg-emerald-500/90 text-white text-[11px] sm:text-xs font-semibold uppercase tracking-[0.25em] px-4 py-1.5 rounded-full shadow-lg mb-5">
            Portal Resmi RPJMD
        </span>

        <h1 data-aos="fade-up"
            class="text-white font-extrabold tracking-tight leading-none text-5xl sm:text-7xl lg:text-8xl drop-shadow-2xl">
            PASURUAN
        </h1>

        <p data-aos="fade-up" data-aos-delay="150"
           class="mt-4 text-white/85 text-xs sm:text-base lg:text-lg font-light uppercase tracking-[0.3em]">
            Gerakan Menuju Masa Depan 2025&ndash;2029
        </p>

        <!-- Indikator scroll -->
        <div data-aos="fade-up" data-aos-delay="300" class="mt-8 flex flex-col items-center gap-2">
            <span class="w-px h-10 bg-gradient-to-b from-white/70 to-transparent"></span>
        </div>
    </div>
</div>
