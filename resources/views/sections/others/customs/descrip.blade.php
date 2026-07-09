{{-- Visi Utama Daerah + Indikator Makro RPJMD (blok setelah hero) --}}
@php
    // Data dinamis — dikelola Super Admin lewat panel admin (Profil Daerah).
    $regionStats = \App\Models\RegionStat::active();
@endphp

<section class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:!px-20 py-16 lg:py-24" data-aos="fade-up" id="about">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

        <!-- Kiri: teks visi + strategi + statistik -->
        <div class="flex flex-col justify-center order-2 lg:order-1">
            <span class="text-[#2563eb] font-bold tracking-[0.25em] text-xs uppercase mb-4">Visi Utama Daerah</span>

            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-[1.15] text-slate-900 mb-6">
                Wujudkan Kabupaten Pasuruan yang
                <span class="text-[#2563eb]">Maju, Sejahtera, dan Berkeadilan.</span>
            </h2>

            <!-- Strategi Pentahelix -->
            <div class="bg-blue-50 border-l-4 border-[#2563eb] rounded-r-xl p-5 mb-8">
                <h3 class="text-[#1d4ed8] font-bold text-sm uppercase tracking-wide mb-1.5">Strategi Pentahelix</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Menjalin kolaborasi produktif antara pemerintah, masyarakat, akademisi, media, dan pelaku usaha untuk percepatan ekonomi inklusif.
                </p>
            </div>

            <!-- Indikator makro (dinamis) -->
            @if ($regionStats->isNotEmpty())
                <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-8">
                    @foreach ($regionStats as $stat)
                        <div class="bg-white p-4 rounded-2xl shadow-[0_4px_20px_-8px_rgba(15,23,42,0.15)] border border-slate-100 text-center">
                            <h4 class="text-[10px] sm:text-[11px] text-slate-400 uppercase tracking-wider mb-1.5">{{ $stat->label }}</h4>
                            <p class="text-2xl sm:text-3xl font-extrabold" style="color: {{ $stat->color }}">{{ $stat->value }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <div>
                <a href="{{ url('/profile') }}"
                   class="inline-flex items-center gap-2 text-white font-semibold text-sm uppercase tracking-wide py-3.5 px-7 rounded-xl shadow-lg shadow-blue-500/30 transition hover:-translate-y-0.5 hover:shadow-xl"
                   style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    Pelajari Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Kanan: gambar -->
        <div class="order-1 lg:order-2" data-aos="fade-left" data-aos-delay="150">
            <div class="rounded-3xl overflow-hidden shadow-2xl shadow-blue-500/10 border-4 border-white h-72 sm:h-96 lg:h-[460px]">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200&auto=format&fit=crop"
                     alt="Pembangunan Kabupaten Pasuruan"
                     class="w-full h-full object-cover" loading="lazy" decoding="async">
            </div>
        </div>
    </div>
</section>
