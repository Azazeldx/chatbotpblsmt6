{{-- Visi & Misi Kabupaten Pasuruan (halaman Profile) --}}
@php
    $missions = [
        'Peningkatan kualitas keimanan & kesalehan sosial.',
        'Peningkatan kualitas hidup & pemberdayaan masyarakat.',
        'Penguatan ekonomi lokal & kemandirian pangan.',
        'Optimalisasi tata kelola pemerintahan yang responsif.',
        'Percepatan infrastruktur wilayah yang merata.',
    ];
@endphp

<section class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:!px-20 py-16 lg:py-24" data-aos="fade-up">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

        <!-- Kiri: Visi & Misi -->
        <div>
            <!-- Visi -->
            <div class="flex items-center gap-4 mb-4">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900">Visi</h2>
                <span class="flex-grow h-0.5 bg-blue-200 rounded-full"></span>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-slate-800 leading-snug mb-12">
                "Pasuruan yang Maju, Sejahtera, dan Berkeadilan"
            </p>

            <!-- Misi -->
            <div class="flex items-center gap-4 mb-6">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900">Misi</h2>
                <span class="flex-grow h-0.5 bg-blue-200 rounded-full"></span>
            </div>
            <ul class="space-y-4">
                @foreach ($missions as $i => $mission)
                    <li class="flex items-center gap-4">
                        <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-50 text-[#2563eb] font-bold text-sm flex items-center justify-center">
                            {{ $i + 1 }}
                        </span>
                        <span class="text-slate-700 text-[15px] font-medium">{{ $mission }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Kanan: kolase gambar + kartu Pilar Utama -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Kolom kiri -->
            <div class="flex flex-col gap-4">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop"
                     alt="Analisis data pembangunan" loading="lazy" decoding="async"
                     class="rounded-2xl object-cover w-full h-44 lg:h-56 shadow-lg">

                <!-- Kartu Pilar Utama -->
                <div class="rounded-2xl p-5 text-white shadow-xl flex-grow"
                     style="background: linear-gradient(150deg, #3b82f6 0%, #2563eb 100%);">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-bullseye text-lg"></i>
                        <h3 class="font-bold text-lg leading-tight">Pilar<br>Utama</h3>
                    </div>
                    <p class="text-[13px] leading-relaxed text-white/90">
                        "Sinergi Tanpa Batas Demi Masa Depan Berkelanjutan. Kolaborasi pentahelix sebagai motor penggerak percepatan pembangunan daerah."
                    </p>
                </div>
            </div>

            <!-- Kolom kanan (staggered) -->
            <div class="flex flex-col gap-4 pt-8">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=800&auto=format&fit=crop"
                     alt="Kolaborasi tim" loading="lazy" decoding="async"
                     class="rounded-2xl object-cover w-full h-40 lg:h-44 shadow-lg">
                <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=800&auto=format&fit=crop"
                     alt="Perencanaan strategis" loading="lazy" decoding="async"
                     class="rounded-2xl object-cover w-full h-52 lg:h-72 shadow-lg">
            </div>
        </div>
    </div>
</section>
