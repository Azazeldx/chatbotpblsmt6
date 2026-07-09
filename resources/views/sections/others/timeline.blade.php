{{-- Timeline Strategis RPJMD — blok gelap 4 tahapan --}}
@php
    $timelineSteps = [
        ['no' => '1', 'year' => '2024', 'title' => 'Persiapan Teknis',  'desc' => 'Analisis mendalam mengenai isu strategis daerah.'],
        ['no' => '2', 'year' => '2025', 'title' => 'Sinkronisasi',      'desc' => 'Penyusunan rancangan awal & konsultasi publik terpadu.'],
        ['no' => '3', 'year' => '2026', 'title' => 'Tahun Aksi',        'desc' => 'Implementasi program kerja lintas sektoral serentak.'],
        ['no' => '4', 'year' => '2029', 'title' => 'Keberlanjutan',     'desc' => 'Audit capaian target dan penyiapan estafet visi.'],
    ];
@endphp

<section class="relative overflow-hidden" style="background: linear-gradient(120deg, #0f172a 0%, #111c34 55%, #0b2a24 100%);">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:!px-20 py-16 lg:py-20" data-aos="fade-up">

        <h2 class="text-white text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-3">Timeline Strategis RPJMD</h2>
        <p class="text-slate-400 text-sm sm:text-base max-w-xl mb-12 leading-relaxed">
            Transparansi proses perumusan regulasi hingga tahap implementasi demi Pasuruan yang lebih baik.
        </p>

        <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6">
            <!-- Garis penghubung (desktop) -->
            <div class="hidden lg:block absolute top-5 left-0 right-0 h-px bg-white/10"></div>

            @foreach ($timelineSteps as $i => $step)
                <div class="relative" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-blue-900/50 mb-5 relative z-10"
                         style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        {{ $step['no'] }}
                    </div>
                    <h3 class="text-[#60a5fa] font-bold text-sm mb-2">{{ $step['year'] }} &bull; {{ $step['title'] }}</h3>
                    <p class="text-slate-400 text-[13px] leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
